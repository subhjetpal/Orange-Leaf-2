<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TradeJournal;
use App\Models\TradeSummary;
use App\Models\Scheme;
use App\Models\Sector;
use App\Models\Lend;
use App\Models\Expense;
use App\Models\Comment;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    private function riskRange($Capital,$TotalRisk,$usedRisk,$RiskP){
        if($usedRisk<$TotalRisk){
            return $TotalRisk;
        }else{
            $usedRisk_=$usedRisk-$TotalRisk;
            $TotalRisk_=($Capital-$TotalRisk)*$RiskP;
            // NEWTotalRisk, PREVTotalRisk,  (based on NEW and PREv Total Risk) -> positionalRisk, InMkt_Positional
            // $InMktRiskSwing-$swingTotalRisk
            // ($swingCap-$swingTotalRisk) * $RiskP
            // 
            return $this->riskRange($Capital,$TotalRisk_,$usedRisk_,$RiskP);
        }
    }
    function template(Request $req)
    {

        $Data = TradeJournal::all();

        // Format the data in the required format for ApexCharts
        $chartData = [];
        foreach ($Data as $item) {
            $chartData[] = [
                'x' => $item->Date, // Replace 'x' with your property for the x-axis data
                'y' => $item->Entry, // Replace 'y' with your property for the y-axis data
            ];
        }

        $jsonData = json_encode($chartData); // to use in Apex Script

        return view('home.template', [
            'jsonData' => $jsonData,
        ]);
    }
    function addComment(Request $req)
    {
        $comment = new Comment;

        $comment->UserID = $req->session()->get('user')['UserID'];
        $comment->SchemeID = '23TRA7546';
        $comment->TradeID = $req->TradeID;
        $comment->CommentID = rand(1000, 9999);
        $comment->Date = date("ymd");
        $comment->Comment = $req->comment;

        $comment->save();

        return redirect('open-trade');
    }
    function riskFactor(Request $req)
    {
        $currentMonth = date('n');
        $currentYear = date('Y');
        $quarterStartMonth = floor(($currentMonth - 1) / 3) * 3 + 1;
        $LatestQuarterDate = date('Y-m-d', mktime(0, 0, 0, $quarterStartMonth, 1, $currentYear));

        $StartDate = $LatestQuarterDate; // quarter
        $EndDate = date('Y-m-d'); // today

        
        // Scheme
        $Capital = Scheme::where('SchemeID', '23EGD8564')->first();
        $equityCap = $Capital->Capital;
        $swingCap = $equityCap * 0.4;
        $positionalCap = $equityCap * 0.5;

        $Capital = Scheme::where('SchemeID', '23TRA7546')->first();
        $intraCap = $Capital->Capital;
        $optionsCap = $intraCap * 0.80;
        $commodityCap = $intraCap * 0.20;

        // Equity
        $journalData = TradeJournal::where(function($query) {
            $query->where('Order', 'Open')
                  ->orWhere('Order', 'In Process');
        })
        ->where('Instrument', 'Equity')
        ->where('Trade', 'Swing')
        ->get();

        $journalTrade = $journalData->toArray();
        $tradeCollect = collect($journalTrade);

        $InMktRiskSwing = $tradeCollect->sum('Risk');

        $journalData = TradeJournal::where(function($query) {
            $query->where('Order', 'Open')
                  ->orWhere('Order', 'In Process');
        })
        ->where('Instrument', 'Equity')
        ->where('Trade', 'Positional')
        ->get();

        $journalTrade = $journalData->toArray();
        $tradeCollect = collect($journalTrade);

        $InMktRiskPositional = $tradeCollect->sum('Risk');

        // Expense
        $Equity = Expense::where('Instrument', 'Equity')
            ->whereBetween('Date', [$StartDate, $EndDate])
            ->get();

        $Expense_ = $Equity->toArray();
        $ExpenseCollect = collect($Expense_);

        $equityExpense = $ExpenseCollect->sum('Amount');

        $Options = Expense::where('Instrument', 'Options')
            ->whereBetween('Date', [$StartDate, $EndDate])
            ->get();

        $Expense_ = $Options->toArray();
        $ExpenseCollect = collect($Expense_);

        $optionsExpense = $ExpenseCollect->sum('Amount');

        $Commodity = Expense::where('Instrument', 'Commodity')
            ->whereBetween('Date', [$StartDate, $EndDate])
            ->get();

        $Expense_ = $Commodity->toArray();
        $ExpenseCollect = collect($Expense_);

        $commodityExpense = $ExpenseCollect->sum('Amount');

        // turnover
        $summaryData = TradeSummary::where('Instrument', 'Equity')
            ->where('Trade', 'Positional')
            ->whereBetween('Date', [$StartDate, $EndDate])
            ->get();

        $summaryTrade = $summaryData->toArray();
        $summaryCollect = collect($summaryTrade);

        $turnoverPositional = $summaryCollect->sum('Profit_Loss');

        $summaryData = TradeSummary::where('Instrument', 'Equity')
            ->where('Trade', 'Swing')
            ->whereBetween('Date', [$StartDate, $EndDate])
            ->get();

        $summaryTrade = $summaryData->toArray();
        $summaryCollect = collect($summaryTrade);

        $turnoverSwing = $summaryCollect->sum('Profit_Loss');

        $summaryData = TradeSummary::where('Instrument', 'Options')
            ->whereBetween('Date', [$StartDate, $EndDate])
            ->get();

        $summaryTrade = $summaryData->toArray();
        $summaryCollect = collect($summaryTrade);

        $turnOverOptions = $summaryCollect->sum('Profit_Loss');

        $summaryData = TradeSummary::where('Instrument', 'Commodity')
            ->whereBetween('Date', [$StartDate, $EndDate])    
            ->get();

        $summaryTrade = $summaryData->toArray();
        $summaryCollect = collect($summaryTrade);

        $turnOverCommodity = $summaryCollect->sum('Profit_Loss');

       

        // $Allocation = Sector::where('SchemeID','23TRA7546')
        // ->where()
        // ->get();
        

        $positionalRisk = $equityCap * 0.01;
        $swingRisk = $swingCap * 0.01;
        $optionsRisk = $optionsCap * 0.005;
        $commodityRisk = $commodityCap * 0.01;

        $positionalTotalRisk = $positionalCap * 0.1;
        $swingTotalRisk = $swingCap * 0.1;
        $optionsTotalRisk = $optionsCap * 0.05;
        $commodityTotalRisk = $commodityCap * 0.1;

        // UsedRisk = InMktRisk - p/(l)

        $PostionalUsedRisk = $InMktRiskPositional - $turnoverPositional;
        $SwingUsedRisk = $InMktRiskSwing - $turnoverSwing;

        $positional_TotalRisk=$this->riskRange($positionalCap,$positionalTotalRisk,$PostionalUsedRisk,0.1);
        $swing_TotalRisk=$this->riskRange($swingCap,$swingTotalRisk,$SwingUsedRisk,0.1);
        $options_TotalRisk=$this->riskRange($optionsCap,$optionsTotalRisk,$turnOverOptions*-1,0.05);
        $commodity_TotalRisk=$this->riskRange($commodityCap,$commodityTotalRisk,$turnOverCommodity*-1,0.1);

        $positionalRisk = $positional_TotalRisk<$positionalTotalRisk?($equityCap-$positionalTotalRisk) * 0.01:$positionalRisk;
        $swingRisk = $swing_TotalRisk<$swingTotalRisk?($swingCap-$swingTotalRisk) * 0.01:$swingRisk;
        $optionsRisk = $options_TotalRisk<$commodityTotalRisk?($optionsCap-$optionsTotalRisk) * 0.005:$optionsRisk;
        $commodityRisk = $commodity_TotalRisk<$commodityTotalRisk?($commodityCap-$commodityTotalRisk) * 0.01:$commodityRisk;

        $InMkt_Positional=$positional_TotalRisk<$positionalTotalRisk?$InMktRiskPositional-$positionalTotalRisk:$InMktRiskPositional;
        $InMkt_Swing=$swing_TotalRisk<$swingTotalRisk?$InMktRiskSwing-$swingTotalRisk:$InMktRiskSwing;
        $turnOver_Options=$options_TotalRisk<$commodityTotalRisk?$turnOverOptions-$optionsTotalRisk:$turnOverOptions;
        $turnOver_Commodity=$commodity_TotalRisk<$commodityTotalRisk?$turnOverCommodity-$commodityTotalRisk:$turnOverCommodity;

        $riskPossibleSwing = $swing_TotalRisk - $InMkt_Swing + $turnoverSwing;
        $riskPossiblePositional = $positional_TotalRisk - $InMkt_Positional + $turnoverPositional;
        $riskPossibleOptions = $options_TotalRisk+$turnOver_Options;
        $riskPossibleCommodity = $commodity_TotalRisk+$turnOver_Commodity;

        $tradePossibleSwing = $riskPossibleSwing / $swingRisk;
        $tradePossiblePositional = $riskPossiblePositional / $positionalRisk;
        $tradePossibleOptions = $riskPossibleOptions / $optionsRisk;
        $tradePossibleCommodity = $riskPossibleCommodity / $commodityRisk;

        return view('home.risk-factor', [
            // Positional
            'positionalCap' => $positionalCap,
            'positionalRisk' => $positionalRisk,
            'InMktRiskPositional' => $InMktRiskPositional,
            'turnoverPositional' => $turnoverPositional,
            'positiionalTotalRisk' => $positional_TotalRisk,
            'riskPossiblePositional' => $riskPossiblePositional,
            'tradePossiblePositional' => round($tradePossiblePositional, 2),
            'equityExpense' => $equityExpense,
            // Swing
            'swingCap' => $swingCap,
            'swingRisk' => $swingRisk,
            'InMktRiskSwing' => $InMktRiskSwing,
            'turnoverSwing' => $turnoverSwing,
            'swingTotalRisk' => $swing_TotalRisk,
            'riskPossibleSwing' => $riskPossibleSwing,
            'tradePossibleSwing' => round($tradePossibleSwing, 2),
            // Options
            'optionsCap' => $optionsCap,
            'optionsRisk' => $optionsRisk,
            'turnOverOptions' => $turnOverOptions,
            'optionsTotalRisk' => $options_TotalRisk,
            'riskPossibleOptions' => $riskPossibleOptions,
            'tradePossibleOptions' => round($tradePossibleOptions, 2),
            'optionsExpense' => $optionsExpense,
            // Commodity
            'commodityCap' => $commodityCap,
            'commodityRisk' => $commodityRisk,
            'turnOverCommodity' => $turnOverCommodity,
            'commodityTotalRisk' => $commodity_TotalRisk,
            'riskPossibleCommodity' => $riskPossibleCommodity,
            'tradePossibleCommodity' => round($tradePossibleCommodity, 2),
            'commodityExpense' => $commodityExpense,
            // Period
            'StartDate' => $StartDate, 'EndDate' => $EndDate
            
        ]);
    }
    function openTrade(Request $req)
    {
        $data = TradeJournal::where('Order', 'Open')
            ->orWhere('Order', 'In Process')
            ->get();
        return view('home.open-trade', ['trade' => $data->toArray()]);
    }
    function viewTrade(Request $req, $TradeID)
    {
        if (!empty($TradeID)) {
            $data = TradeJournal::where('TradeID', $TradeID)->first();
            $comment = Comment::where('TradeID', $TradeID)->first();
            $Comment = (!empty($comment->Comment)) ? $comment->Comment : "No Comment";
            return view('home.view-trade', ['val' => $data->toArray(), 'Comment' => $Comment]);
        } else {
            return redirect('open-trade');
        }
    }
    function addEntry(Request $req)
    {
        if ($req->Order == 'In Process') {

            // date format to 10MAR2022
            // $DateToText = date('d', strtotime($Date)) . strtoupper(date('M', strtotime($Date))) . date('Y', strtotime($Date));

            // $TradeID = $Script . '_' . $DateToText . '_' . strtoupper($Order);

            $tb = new TradeJournal;

            $tb->UserID = $req->session()->get('user')['UserID'];
            $tb->SchemeID = '23EGD8564';
            $tb->Instrument = $req->Type;
            $tb->Trade = $req->Trade;
            $tb->Order =  $req->Order;
            // $Date = $req->Date;
            $tb->Chart = $req->Chart;
            $tb->Script = strtoupper($req->Script);
            $tb->System = $req->System;
            $tb->Entry = $req->Entry;
            $tb->Stop_Loss = $req->Stop_Loss;
            $tb->Target1_2 = $req->Target1_2;
            $tb->Target1_3 = $req->Target1_3;
            // $Exit = $req->Exit;
            $tb->Quantity = $req->Quantity;
            $tb->Candle = $req->Candle;
            $tb->Risk = $req->Risk;
            $tb->save();

            $req->session()->put('alert', 'Successfully Recorded In Process');
        } elseif ($req->Trade == 'Dividend') {
            $Trade =  $req->Trade;
            $Type = $req->Type;
            // $Order =  $req->Order;
            $Date = $req->Date;
            // $Chart = $req->Chart;
            $Script = strtoupper($req->Script);
            // $System = $req->System;
            $Entry = 0;
            // $Stop_Loss = $req->Stop_Loss;
            // $Target1_2 = $req->Target1_2;
            // $Target1_3 = $req->Target1_3;
            $Exit = $req->Exit;
            $Quantity = $req->Quantity;
            // $Candle = $req->Candle;
            // $Risk = $req->Risk;

            // date format to 10MAR2022
            $DateToText = date('d', strtotime($Date)) . strtoupper(date('M', strtotime($Date))) . date('Y', strtotime($Date));

            $TradeID_S = $Script . '_' . $DateToText . '_' . strtoupper($Trade);


            // Summary
            $Transact = 'Buy';

            if ($Transact == 'Buy') {
                $Percent = ($Exit - $Entry) * 100 / $Exit;
            }
            $Profit_Loss = ($Exit - $Entry) * $Quantity;

            $summary = new TradeSummary;

            $summary->UserID = $req->session()->get('user')['UserID'];
            $summary->SchemeID = '23EGD8564';
            $summary->TradeID = $TradeID_S;
            $summary->Instrument = $Type;
            $summary->Trade = $Trade;
            $summary->Transact = $Transact;
            $summary->Date = $Date;
            $summary->Script = $Script;
            $summary->Entry = $Entry;
            $summary->Exit = $Exit;
            $summary->Quantity = $Quantity;
            $summary->Percent = $Percent;
            $summary->Profit_Loss = $Profit_Loss;

            $summary->save();

            $req->session()->put('alert', 'Successfully Recorded Dividend');
        } elseif ($req->Trade == 'Intraday' && ($req->Order == 'Buy' || $req->Order == 'Short')) {
            $Trade =  $req->Trade;
            $Type = $req->Type;
            $Order =  $req->Order;
            $Date = $req->Date;
            $Chart = $req->Chart;
            $Script = $req->Script; //SCRIPT1000CE
            $System = $req->System;
            $Entry = $req->Entry;
            $Stop_Loss = $req->Stop_Loss;
            $Target1_2 = empty($req->Target1_2) ? 0 : $req->Target1_2;
            $Target1_3 = empty($req->Target1_3) ? 0 : $req->Target1_3;
            $Exit = $req->Exit;
            $Quantity = $req->Quantity;
            $Candle = $req->Candle;
            $Risk = $req->Risk;
            $Others=$req->Others;
            
            $value=(($Order == 'Buy') ? $Exit : $Entry);

            if ($Type == 'Options') {
                $STT = $value * $Quantity * 0.000625;
                $Charges = $req->Charges;
            } elseif ($Type == 'Equity') {
                $STT = $value * $Quantity * 0.00025;
                $Charges = $req->Charges;
            } elseif ($Type == 'Commodity') {
                $STT = $value * $Quantity * 0.0001;
                $Charges = $req->Charges;
            } 

            // date format to 10MAR2022
            $DateToText = date('d', strtotime($Date)) . strtoupper(date('M', strtotime($Date))) . date('Y', strtotime($Date));

            $TradeID = $Script . '_' . $DateToText . '_' . strtoupper($Trade) . '_' . strtoupper($Order);

            $numRows = TradeJournal::where('TradeID', 'LIKE', $TradeID . '%')
                ->count();
            $TradeID = $numRows > 0 ? $TradeID . $numRows + 1 : $TradeID;
            // $TradeID_S = $Script . '_' . $DateToText . '_' . strtoupper($Trade);

            // $Last_Modified=date("Y-m-d");

            // Image Upload -----------------------
            $file = $req->file('fileToUpload');
            $fileName = strtotime("now") . '_' . $file->getClientOriginalName();
            $filePath = 'images/' . $fileName;

            if (Storage::exists($filePath)) {
                $req->session()->put('alert', 'Image Already Exixts');
                return redirect('open-trade');
            } else {
                $file->move(public_path('images'), $fileName);
                $entry = new TradeJournal;

                $entry->UserID = $req->session()->get('user')['UserID'];
                $entry->SchemeID = '23TRA7546';
                $entry->TradeID = $TradeID;
                $entry->Trade = $Trade;
                $entry->Instrument = $Type;
                $entry->Order = $Order;
                $entry->Date = $Date;
                $entry->Chart = $Chart;
                $entry->Script = $Script;
                $entry->System = $System;
                $entry->Entry = $Entry;
                $entry->Stop_Loss = $Stop_Loss;
                $entry->Target1_2 = $Target1_2;
                $entry->Target1_3 = $Target1_3;
                $entry->Exit = $Exit;
                $entry->Quantity = $Quantity;
                $entry->Candle = $Candle;
                $entry->Risk = $Risk;
                $entry->STT = $STT;
                $entry->ImageURL = $filePath;

                $entry->save();

                $Transact = $Order;
                // $Transact = ($Entry > $Stop_Loss) ? 'Buy' : 'Short';

                if ($Transact == 'Buy') {
                    $Percent = ($Exit - $Entry) * 100 / $Entry;
                } else {
                    $Percent = ($Entry - $Exit) * 100 / $Entry;
                }
                $Profit_Loss = (($Transact == 'Buy') ? ($Exit - $Entry) : ($Entry - $Exit)) * $Quantity;

                $summary = new TradeSummary;

                $summary->UserID = $req->session()->get('user')['UserID'];
                $summary->SchemeID = '23TRA7546';
                $summary->TradeID = $TradeID;
                $summary->Trade = $Trade;
                $summary->Instrument = $Type;
                $summary->Transact = $Transact;
                $summary->Date = $Date;
                $summary->Script = $Script;
                $summary->Entry = $Entry;
                $summary->Exit = $Exit;
                $summary->Quantity = $Quantity;
                $summary->STT = $STT;
                $summary->Percent = $Percent;
                $summary->Profit_Loss = $Profit_Loss;

                $summary->save();

                $today_date = date("ymd");
                $current_time = date("H:i:s");
                $seconds_value = strtotime("1970-01-01 $current_time UTC");
                $ExpenseID = $today_date . 'D' . $seconds_value;

                $expense = new Expense;

                $expense->UserID = $req->session()->get('user')['UserID'];
                $expense->SchemeID = '23TRA7546';
                $expense->ExpenseID = $ExpenseID;
                $expense->TradeID = $TradeID;
                $expense->Date = $Date;
                $expense->Instrument = $Type;
                $expense->Amount = $Charges;
                $expense->Charges = $Others;

                $expense->save();

                $req->session()->put('alert', 'Successfully Recorded Intraday Order');
                return redirect('open-trade');
            }
        } elseif ($req->Order == 'Open') {

            if ($req->Type == 'Equity') {
                $STT = $req->Entry * $req->Quantity * 0.001;
                $SchemeID = '23EGD8564';
                $Charges=0;
            } elseif ($req->Type == 'Commodity') {
                $STT = 0;
                $SchemeID = '23TRA7546';
                $Charges=$req->Charges;
            } elseif ($req->Type == 'Options'){
                $STT = 0;
                $SchemeID = '23TRA7546';
                $Charges=$req->Charges;
            }

            $Last_Modified=date("Y-m-d");

            // date format to 10MAR2022
            $DateToText = date('d', strtotime($req->Date)) . strtoupper(date('M', strtotime($req->Date))) . date('Y', strtotime($req->Date));

            // $TradeID = $Script . '_' . $DateToText . '_' . strtoupper($Order);

            $TradeID = strtoupper($req->Script) . '_' . $DateToText . '_' . strtoupper($req->Trade) . '_' . 'ENTRY';

            // Image Upload -----------------------
            $file = $req->file('fileToUpload');
            $fileName = strtotime("now") . '_' . $file->getClientOriginalName();
            $filePath = 'images/' . $fileName;

            if (Storage::exists($filePath)) {
                $req->session()->put('alert', 'Image Already Exixts');
                return redirect('open-trade');
            } else {
                $file->move(public_path('images'), $fileName);

                $tb = new TradeJournal;

                $tb->UserID = $req->session()->get('user')['UserID'];
                $tb->SchemeID = $SchemeID;
                $tb->TradeID = $TradeID;
                $tb->Trade = $req->Trade;
                $tb->Instrument = $req->Type;
                $tb->Order =  $req->Order;
                $tb->Date = $req->Date;
                $tb->Chart = $req->Chart;
                $tb->Script = strtoupper($req->Script);
                $tb->System = $req->System;
                $tb->Entry = $req->Entry;
                $tb->Stop_Loss = $req->Stop_Loss;
                $tb->Target1_2 = $req->Target1_2;
                $tb->Target1_3 = $req->Target1_3;
                // $Exit = $req->Exit;
                $tb->Quantity = $req->Quantity;
                $tb->Candle = $req->Candle;
                $tb->Risk = $req->Risk;
                $tb->ImageURL = $filePath;
                $tb->save();

                $today_date = date("ymd");
                $current_time = date("H:i:s");
                $seconds_value = strtotime("1970-01-01 $current_time UTC");
                $ExpenseID = $today_date . 'D' . $seconds_value;

                // $expense = new Expense;

                // $expense->UserID = $req->session()->get('user')['UserID'];
                // $expense->SchemeID = $SchemeID;
                // $expense->ExpenseID = $ExpenseID;
                // $expense->TradeID = $TradeID;
                // $expense->Date = $req->Date;
                // $expense->Instrument = $req->Type;
                // $expense->Amount = $Charges;
                // $expense->Charges = $req->Others;

                // $expense->save();

                $req->session()->put('alert', 'Successfully Created Open Order');
                return redirect('open-trade');
            }
        }
        return redirect('add-entry');
    }
    function modifyEntryFetch(Request $req, $stage, $Order, $TradeID)
    {
        // TradeID NULL mean Upgrade, not NULL mean Edited
        if ($Order == 'In Process' && $stage == "Upgrade") {

            $data = TradeJournal::where('Script', $TradeID)
                ->where('Order', $Order)
                ->first();

            $Entry = $data->Entry;
            $Stop_Loss = $data->Stop_Loss;
            $TradeID = 'NULL';
        } elseif ($Order == 'Open' && $stage == "Upgrade") {

            $data = TradeJournal::where('TradeID', $TradeID)
                ->where('Order', $Order)
                ->first();

            $Script = $data->Script;
            $Trade = $data->Trade;

            $avgEntry = TradeJournal::selectRaw('SUM(Stop_Loss * Quantity)/SUM(Quantity) as avg_sl, SUM(Entry*Quantity)/SUM(Quantity) as avg_entry')
                ->whereIn('TradeID', function ($query) use ($Script, $Trade, $Order) {
                    $query->select('TradeID')
                        ->from((new TradeJournal)->getTable())
                        ->where('Script', $Script)
                        ->where('Order', $Order)
                        ->where('Trade', $Trade);
                })
                ->first();
            $Entry = $avgEntry->avg_entry;
            $Stop_Loss = $avgEntry->avg_sl;
            $TradeID = 'NULL';
        } elseif ($Order == 'Open' && $stage == "Edit") {

            $data = TradeJournal::where('TradeID', $TradeID)
                ->where('Order', $Order)
                ->first();

            $Entry = $data->Entry;
            $Stop_Loss = $data->Stop_Loss;
            $TradeID = $data->TradeID;
        } elseif ($Order == 'Exit' && $stage == "Edit") {

            $data = TradeJournal::where('TradeID', $TradeID)
                ->where('Order', $Order)
                ->first();

            $Entry = $data->Entry;
            $Stop_Loss = $data->Stop_Loss;
            $TradeID = $data->TradeID;
        } else {
            $data = TradeJournal::where('TradeID', $TradeID)
                ->where('Order', $Order)
                ->first();

            $Entry = $data->Entry;
            $Stop_Loss = $data->Stop_Loss;
            $TradeID = $data->TradeID;
        }
        return view('home.modify-entry', ['val' => $data->toArray(), 'Entry' => $Entry,'Stop_Loss' => $Stop_Loss, 'TradeID' => $TradeID]);
    }
    function modifyEntry(Request $req)
    {
        if ($req->Order == 'Open' && $req->TradeID == "NULL") {

            $Trade =  strtoupper($req->Trade);
            $Order =  $req->Order;
            $Date = $req->Date;
            // $Chart = $req->Chart;
            $Script = strtoupper($req->Script);
            $System = $req->System;
            $Entry = $req->Entry;
            $Stop_Loss = $req->Stop_Loss;
            $Target1_2 = empty($req->Target1_2) ? 0 : $req->Target1_2;
            $Target1_3 = empty($req->Target1_3) ? 0 : $req->Target1_3;
            // $Exit = $req->Exit;
            $Quantity = $req->Quantity;
            $Candle = $req->Candle;
            $Risk = $req->Risk;

            $STT = $Entry * $Quantity * 0.001;

            $Last_Modified=date("Y-m-d");

            // date format to 10MAR2022
            $DateToText = date('d', strtotime($Date)) . strtoupper(date('M', strtotime($Date))) . date('Y', strtotime($Date));

            // $TradeID = $Script . '_' . $DateToText . '_' . strtoupper($Order);

            $TradeID = strtoupper($req->Script) . '_' . $DateToText . '_' . strtoupper($req->Trade) . '_' . 'ENTRY';

            // Image Upload -----------------------
            $file = $req->file('fileToUpload');
            $fileName = strtotime("now") . '_' . $file->getClientOriginalName();
            $filePath = 'images/' . $fileName;

            if (Storage::exists($filePath)) {
                $req->session()->put('alert', 'Image Already Exixts');
                return redirect('open-trade');
            } else {
                $file->move(public_path('images'), $fileName);

                $entry = TradeJournal::where('Script', $req->Script)
                    ->where('Order', 'In Process')
                    ->update([
                        'TradeID' => $TradeID,
                        'Order' => $Order,
                        'Date' => $Date,
                        'System' => $System,
                        'Entry' => $Entry,
                        'Stop_Loss' => $Stop_Loss,
                        'Target1_2' => $Target1_2,
                        'Target1_3' => $Target1_3,
                        'Quantity' => $Quantity,
                        'Candle' => $Candle,
                        'Risk' => $Risk,
                        'STT' => $STT,
                        'ImageURL' => $filePath,
                        'Last_Modified' => $Last_Modified
                    ]);

                $req->session()->put('alert', 'Successfully Upgraded to Open Order');
                return redirect('open-trade');
            }
        } elseif ($req->Order == 'Exit' && $req->TradeID == "NULL") {
            $Trade =  $req->Trade;
            $Type = $req->Type;
            $Order =  $req->Order;
            $Date = $req->Date;
            $Chart = $req->Chart;
            $Script = strtoupper($req->Script);
            $System = $req->System;
            $Entry = $req->Entry;
            $Stop_Loss = $req->Stop_Loss;
            // $Target1_2 = empty($req->Target1_2) ? 0 : $req->Target1_2;
            // $Target1_3 = empty($req->Target1_3) ? 0 : $req->Target1_3;
            $Exit = $req->Exit;
            $Quantity = $req->Quantity;
            $Candle = $req->Candle;
            $Risk = $req->Risk;

            if ($req->Type == 'Equity') {
                $EntrySTT = $Entry * $Quantity * 0.001;
                $ExitSTT = $Exit * $Quantity * 0.001;

                $STT = $EntrySTT + $ExitSTT;
                $SchemeID = '23EGD8564';
            } 

            // date format to 10MAR2022
            $DateToText = date('d', strtotime($Date)) . strtoupper(date('M', strtotime($Date))) . date('Y', strtotime($Date));

            $TradeID = $Script . '_' . $DateToText . '_' . strtoupper($Trade) . '_' . strtoupper($Order);
            // $TradeID_S = $Script . '_' . $DateToText . '_' . strtoupper($Trade);
            $numRows = TradeJournal::where('TradeID', 'LIKE', $TradeID . '%')
                ->count();
            $TradeID = $numRows > 0 ? $TradeID . $numRows + 1 : $TradeID;

            // Image Upload -----------------------
            $file = $req->file('fileToUpload');
            $fileName = strtotime("now") . '_' . $file->getClientOriginalName();
            $filePath = 'images/' . $fileName;

            if (Storage::exists($filePath)) {
                $req->session()->put('alert', 'Image Already Exixts');
                return redirect('open-trade');
            } else {
                $file->move(public_path('images'), $fileName);
                $entry = new TradeJournal;

                $entry->UserID = $req->session()->get('user')['UserID'];
                $entry->SchemeID = $SchemeID;
                $entry->TradeID = $TradeID;
                $entry->Trade = $Trade;
                $entry->Instrument = $Type;
                $entry->Order = $Order;
                $entry->Date = $Date;
                $entry->Chart = $Chart;
                $entry->Script = $Script;
                $entry->System = $System;
                $entry->Entry = $Entry;
                $entry->Exit = $Exit;
                $entry->Quantity = $Quantity;
                $entry->Candle = $Candle;
                $entry->Risk = $Risk;
                $entry->STT = $ExitSTT;
                $entry->ImageURL = $filePath;

                $entry->save();

                // $entry = TradeJournal::where('Script', $Script)
                //     ->where('Order', 'Open')
                //     ->where('Trade', $Trade)
                //     ->update(['Order' => 'Entry']);

                $Transact = ($Entry > $Stop_Loss) ? 'Buy' : 'Short';
                // $Transact = $Order;

                if ($Transact == 'Buy') {
                    $Percent = ($Exit - $Entry) * 100 / $Entry;
                } else {
                    $Percent = ($Entry - $Exit) * 100 / $Entry;
                }
                $Profit_Loss = (($Transact == 'Buy') ? ($Exit - $Entry) : ($Entry - $Exit)) * $Quantity;

                $summary = new TradeSummary;

                $summary->UserID = $req->session()->get('user')['UserID'];
                $summary->SchemeID = $SchemeID;
                $summary->TradeID = $TradeID;
                $summary->Trade = $Trade;
                $summary->Instrument = $Type;
                $summary->Transact = $Transact;
                $summary->Date = $Date;
                $summary->Script = $Script;
                $summary->Entry = $Entry;
                $summary->Exit = $Exit;
                $summary->Quantity = $Quantity;
                $summary->STT = $STT;
                $summary->Percent = $Percent;
                $summary->Profit_Loss = $Profit_Loss;

                $summary->save();

                $today_date = date("ymd");
                $current_time = date("H:i:s");
                $seconds_value = strtotime("1970-01-01 $current_time UTC");
                $ExpenseID = $today_date . 'D' . $seconds_value;

                if ($Type == 'Equity') {
                    $Charges = ($Trade == 'Swing') ? 15.93 : 23.60;
                } else {
                    $Charges = 0;
                }
                $Others=$req->Others;

                $expense = new Expense;

                $expense->UserID = $req->session()->get('user')['UserID'];
                $expense->SchemeID = $SchemeID;
                $expense->ExpenseID = $ExpenseID;
                $expense->TradeID = $TradeID;
                $expense->Date = $Date;
                $expense->Instrument = $Type;
                $expense->Amount = $Charges;
                $expense->Charges = $Others;

                $expense->save();

                $req->session()->put('alert', 'Successfully Upgraded to Exit Order');
                return redirect('open-trade');
            }
        } elseif (($req->Order == 'Buy' || $req->Order == 'Short') && $req->TradeID == "NULL") {
            $Trade =  $req->Trade;
            $Type = $req->Type;
            $Order =  $req->Order;
            $Date = $req->Date;
            $Chart = $req->Chart;
            $Script = strtoupper($req->Script);
            $System = $req->System;
            $Entry = $req->Entry;
            $Stop_Loss = $req->Stop_Loss;
            // $Target1_2 = empty($req->Target1_2) ? 0 : $req->Target1_2;
            // $Target1_3 = empty($req->Target1_3) ? 0 : $req->Target1_3;
            $Exit = $req->Exit;
            $Quantity = $req->Quantity;
            $Candle = $req->Candle;
            $Risk = $req->Risk;
            $Others=$req->Others;

            $value = ($Order=='Buy')?$Exit:$Entry;

            if ($req->Type == 'Equity') {
                $STT = $value * $Quantity * 0.000125;
                $SchemeID = '23EGD8564';
                $Charges = $req->Charges;
            } elseif ($req->Type == 'Commodity') {
                $STT = $value * $Quantity * 0.0001;
                $SchemeID = '23TRA7546';
                $Charges = $req->Charges;
            } elseif ($req->Type == 'Options') {
                $STT = $value * $Quantity * 0.000625;
                $SchemeID = '23TRA7546';
                $Charges = $req->Charges;
            }

            $Last_Modified=date("Y-m-d");

            // date format to 10MAR2022
            $DateToText = date('d', strtotime($Date)) . strtoupper(date('M', strtotime($Date))) . date('Y', strtotime($Date));

            $TradeID = $Script . '_' . $DateToText . '_' . strtoupper($Trade) . '_' . strtoupper($Order);
            // $TradeID_S = $Script . '_' . $DateToText . '_' . strtoupper($Trade);
            $numRows = TradeJournal::where('TradeID', 'LIKE', $TradeID . '%')
                ->count();
            $TradeID = $numRows > 0 ? $TradeID . $numRows + 1 : $TradeID;

            // Image Upload -----------------------
            $file = $req->file('fileToUpload');
            $fileName = strtotime("now") . '_' . $file->getClientOriginalName();
            $filePath = 'images/' . $fileName;

            if (Storage::exists($filePath)) {
                $req->session()->put('alert', 'Image Already Exixts');
                return redirect('open-trade');
            } else {
                $file->move(public_path('images'), $fileName);
                $entry = new TradeJournal;

                $entry->UserID = $req->session()->get('user')['UserID'];
                $entry->SchemeID = $SchemeID;
                $entry->TradeID = $TradeID;
                $entry->Trade = $Trade;
                $entry->Instrument = $Type;
                $entry->Order = $Order;
                $entry->Date = $Date;
                $entry->Chart = $Chart;
                $entry->Script = $Script;
                $entry->System = $System;
                $entry->Entry = $Entry;
                $entry->Exit = $Exit;
                $entry->Quantity = $Quantity;
                $entry->Candle = $Candle;
                $entry->Risk = $Risk;
                $entry->STT = $STT;
                $entry->ImageURL = $filePath;

                $entry->save();

                // $entry = TradeJournal::where('Script', $Script)
                //     ->where('Order', 'Open')
                //     ->where('Trade', $Trade)
                //     ->update(['Order' => 'Entry']); // Solution Using Same Condition get Order Date and Quantity is Quantity Equal to Exit Quantity No Issue If not check any Exit Order for this between Open Date to Cuurent Order Date and Add Quantity then Check is it same.

                // $Transact = ($Entry > $Stop_Loss) ? 'Buy' : 'Short';
                $Transact = $Order;

                if ($Transact == 'Buy') {
                    $Percent = ($Exit - $Entry) * 100 / $Entry;
                } else {
                    $Percent = ($Entry - $Exit) * 100 / $Entry;
                }
                $Profit_Loss = (($Transact == 'Buy') ? ($Exit - $Entry) : ($Entry - $Exit)) * $Quantity;

                $summary = new TradeSummary;

                $summary->UserID = $req->session()->get('user')['UserID'];
                $summary->SchemeID = $SchemeID;
                $summary->TradeID = $TradeID;
                $summary->Trade = $Trade;
                $summary->Instrument = $Type;
                $summary->Transact = $Transact;
                $summary->Date = $Date;
                $summary->Script = $Script;
                $summary->Entry = $Entry;
                $summary->Exit = $Exit;
                $summary->Quantity = $Quantity;
                $summary->STT = $STT;
                $summary->Percent = $Percent;
                $summary->Profit_Loss = $Profit_Loss;

                $summary->save();

                $today_date = date("ymd");
                $current_time = date("H:i:s");
                $seconds_value = strtotime("1970-01-01 $current_time UTC");
                $ExpenseID = $today_date . 'D' . $seconds_value;

                $expense = new Expense;

                $expense->UserID = $req->session()->get('user')['UserID'];
                $expense->SchemeID = $SchemeID;
                $expense->ExpenseID = $ExpenseID;
                $expense->TradeID = $TradeID;
                $expense->Date = $Date;
                $expense->Instrument = $Type;
                $expense->Amount = $Charges;
                $expense->Charges = $Others;

                $expense->save();

                $req->session()->put('alert', 'Successfully Upgraded to Exit Order');
                return redirect('open-trade');
            }
        } elseif ($req->Order == 'Open'  && $req->TradeID != "NULL") {
            $Trade =  strtoupper($req->Trade);
            $Type = $req->Type;
            $Order =  $req->Order;
            $Date = $req->Date;
            $Chart = $req->Chart;
            $Script = strtoupper($req->Script);
            $System = $req->System;
            $Entry = $req->Entry;
            $Stop_Loss = $req->Stop_Loss;
            $Target1_2 = empty($req->Target1_2) ? 0 : $req->Target1_2;
            $Target1_3 = empty($req->Target1_3) ? 0 : $req->Target1_3;
            // $Exit = $req->Exit;
            $Quantity = $req->Quantity;
            $Candle = $req->Candle;
            $Risk = $req->Risk;
            

            $STT = $Entry * $Quantity * 0.001;

            $Last_Modified=date("Y-m-d");

            // date format to 10MAR2022
            // $DateToText = date('d', strtotime($Date)) . strtoupper(date('M', strtotime($Date))) . date('Y', strtotime($Date));

            // $TradeID = strtoupper($req->Script) . '_' . $DateToText . '_' . strtoupper($req->Trade) . '_' . 'ENTRY';

            // Image Upload -----------------------
            $file = $req->file('fileToUpload');
            $fileName = strtotime("now") . '_' . $file->getClientOriginalName();
            $filePath = 'images/' . $fileName;

            if (Storage::exists($filePath)) {
                $req->session()->put('alert', 'Image Already Exixts');
                return redirect('open-trade');
            } else {
                $file->move(public_path('images'), $fileName);

                $entry = TradeJournal::where('Script', $Script)
                    ->where('TradeID', $req->TradeID)
                    ->update([
                        // 'TradeID' => $TradeID,
                        // 'Order' => $Order,
                        'Instrument' => $Type,
                        // 'Date' => $Date,
                        'System' => $System,
                        'Chart' => $Chart,
                        'Entry' => $Entry,
                        'Stop_Loss' => $Stop_Loss,
                        'Target1_2' => $Target1_2,
                        'Target1_3' => $Target1_3,
                        'Quantity' => $Quantity,
                        'Candle' => $Candle,
                        'Risk' => $Risk,
                        'STT' => $STT,
                        'ImageURL' => $filePath,
                        'Last_Modified' => $Last_Modified
                    ]);

                $req->session()->put('alert', 'Successfully Edited Recorded Open Order');
                return redirect('open-trade');
            }
        } elseif (($req->Order == 'Bonus' || $req->Order == 'Split')  && $req->TradeID != "NULL") {
            $Trade =  $req->Trade;
            $Type = $req->Type;
            $Order =  $req->Order;
            $Date = $req->Date;
            $Chart = $req->Chart;
            $Script = strtoupper($req->Script);
            $System = $req->System;
            $Entry = $req->Entry;
            $Stop_Loss = $req->Stop_Loss;
            $Target1_2 = empty($req->Target1_2) ? 0 : $req->Target1_2;
            $Target1_3 = empty($req->Target1_3) ? 0 : $req->Target1_3;
            $Exit = $req->Exit;
            $Quantity = $req->Quantity;
            $Candle = $req->Candle;
            $Risk = $req->Risk;
            

            $STT = $Entry * $Quantity * 0.001;

            $Last_Modified=date("Y-m-d");

            // date format to 10MAR2022
            $DateToText = date('d', strtotime($Date)) . strtoupper(date('M', strtotime($Date))) . date('Y', strtotime($Date));

            $TradeID = strtoupper($req->Script) . '_' . $DateToText . '_' . strtoupper($req->Trade) . '_' . strtoupper($req->Order);

            $numRows = TradeJournal::where('TradeID', 'LIKE', $TradeID . '%')
                ->count();
            $TradeID = $numRows > 0 ? $TradeID . $numRows + 1 : $TradeID;

            // Image Upload -----------------------
            $file = $req->file('fileToUpload');
            $fileName = strtotime("now") . '_' . $file->getClientOriginalName();
            $filePath = 'images/' . $fileName;

            if (Storage::exists($filePath)) {
                $req->session()->put('alert', 'Image Already Exixts');
                return redirect('open-trade');
            } else {
                $file->move(public_path('images'), $fileName);

                $entry = TradeJournal::where('TradeID', $req->TradeID)
                    ->update([
                        // 'TradeID' => $TradeID_prev,
                        'Order' => $Order,
                        // 'Date' => $Date,
                        // 'System' => $System,
                        // 'Entry' => $Entry,
                        // 'Stop_Loss' => $Stop_Loss,
                        // 'Target1_2' => $Target1_2,
                        // 'Target1_3' => $Target1_3,
                        // 'Quantity' => $Quantity,
                        // 'Candle' => $Candle,
                        // 'Risk' => $Risk,
                        // 'STT' => $STT,
                        // 'ImageURL' => $filePath,
                        'Last_Modified' => $Last_Modified
                    ]);

                $entry = new TradeJournal;

                $entry->UserID = $req->session()->get('user')['UserID'];
                $entry->SchemeID = '23EGD8564';
                $entry->TradeID = $TradeID;
                $entry->Trade = $Trade;
                $entry->Instrument = $Type;
                $entry->Order = 'Open';
                $entry->Date = $Date;
                $entry->Chart = $Chart;
                $entry->Script = $Script;
                $entry->System = $System;
                $entry->Entry = $Entry;
                $entry->Stop_Loss = $Stop_Loss;
                $entry->Target1_2 = $Target1_2;
                $entry->Target1_3 = $Target1_3;
                $entry->Exit = $Exit;
                $entry->Quantity = $Quantity;
                $entry->Candle = $Candle;
                $entry->Risk = $Risk;
                $entry->STT = $STT;
                $entry->ImageURL = $filePath;

                $entry->save();

                $req->session()->put('alert', 'Successfully Edited Bonus Order');
                return redirect('open-trade');
            }
        }
        elseif ($req->Order == 'Exit' && $req->TradeID != "NULL") {
            $Trade =  $req->Trade;
            $Type = $req->Type;
            // $Order =  $req->Order;
            $Date = $req->Date;
            $Chart = $req->Chart;
            $Script = strtoupper($req->Script);
            $System = $req->System;
            $Entry = $req->Entry;
            $Stop_Loss = $req->Stop_Loss;
            // $Target1_2 = empty($req->Target1_2) ? 0 : $req->Target1_2;
            // $Target1_3 = empty($req->Target1_3) ? 0 : $req->Target1_3;
            $Exit = $req->Exit;
            $Quantity = $req->Quantity;
            $Candle = $req->Candle;
            $Risk = $req->Risk;

            $Last_Modified=date("Y-m-d");

            if ($req->Type == 'Equity') {
                $EntrySTT = $Entry * $Quantity * 0.001;
                $ExitSTT = $Exit * $Quantity * 0.001;

                $STT = $EntrySTT + $ExitSTT;
                $SchemeID = '23EGD8564';
            } 

            // date format to 10MAR2022
            $DateToText = date('d', strtotime($Date)) . strtoupper(date('M', strtotime($Date))) . date('Y', strtotime($Date));

            $TradeID = $Script . '_' . $DateToText . '_' . strtoupper($Trade) . '_' . 'EXIT';
            // $TradeID_S = $Script . '_' . $DateToText . '_' . strtoupper($Trade);

            // Image Upload -----------------------
            $file = $req->file('fileToUpload');
            $fileName = strtotime("now") . '_' . $file->getClientOriginalName();
            $filePath = 'images/' . $fileName;

            if (Storage::exists($filePath)) {
                $req->session()->put('alert', 'Image Already Exixts');
                return redirect('open-trade');
            } else {
                $file->move(public_path('images'), $fileName);

                $entry = TradeJournal::where('Script', $Script)
                    ->where('TradeID', $req->TradeID)
                    ->update([
                        // 'TradeID' => $TradeID,
                        // 'Order' => $Order,
                        'Instrument' => $Type,
                        // 'Date' => $Date,
                        'System' => $System,
                        'Entry' => $Entry,
                        'Exit' => $Exit,
                        'Quantity' => $Quantity,
                        'Candle' => $Candle,
                        'Risk' => $Risk,
                        'STT' => $ExitSTT,
                        'ImageURL' => $filePath,
                        'Last_Modified' => $Last_Modified
                    ]);

                $Transact = ($Entry > $Stop_Loss) ? 'Buy' : 'Short';

                if ($Transact == 'Buy') {
                    $Percent = ($Exit - $Entry) * 100 / $Entry;
                } else {
                    $Percent = ($Entry - $Exit) * 100 / $Entry;
                }
                $Profit_Loss = (($Transact == 'Buy') ? ($Exit - $Entry) : ($Entry - $Exit)) * $Quantity;

                // $reqTradeId_ex = explode('_', $req->TradeID);
                // $reqTradeId_s = trim($reqTradeId_ex[0]) . '_' . trim($reqTradeId_ex[1]) . '_' . trim($reqTradeId_ex[2]);

                $summary = TradeSummary::where('Script', $req->Script)
                    ->where('TradeID', $req->TradeID)
                    ->update([
                        // 'TradeID' => $TradeID,
                        'Trade' => $Trade,
                        'Transact' => $Transact,
                        'Date' => $Date,
                        'Script' => $Script,
                        'Entry' => $Entry,
                        'Exit' => $Exit,
                        'Quantity' => $Quantity,
                        'STT' => $STT,
                        'Percent' => $Percent,
                        'Profit_Loss' => $Profit_Loss,
                        'Last_Modified' => $Last_Modified
                    ]);

                $req->session()->put('alert', 'Successfully Edited Recorded Exit Order');
                return redirect('open-trade');
            }
        }
    }
    function isClosed(Request $req, $TradeID)
    {
        $Last_Modified=date("Y-m-d");
        $entry = TradeJournal::where('TradeID', $TradeID)
            ->update([
                'Order' => 'Entry',
                'Last_Modified'=>$Last_Modified
            ]);

        $req->session()->put('alert', 'Successfully Closed Open Order');
        return redirect('open-trade');
    }
    function tradeJournal(Request $req)
    {
        $currentMonth = date('n');
        $currentYear = date('Y');
        $quarterStartMonth = floor(($currentMonth - 1) / 3) * 3 + 1;
        $LatestQuarterDate = date('Y-m-d', mktime(0, 0, 0, $quarterStartMonth, 1, $currentYear));

        $StartDate = (!empty($req->StartDate)) ? $req->StartDate : $LatestQuarterDate; // quarter
        $EndDate = (!empty($req->EndDate)) ? $req->EndDate : date('Y-m-d'); // today

        $data = TradeJournal::whereBetween('Date', [$StartDate, $EndDate])->get();

        // $trade = $data->toArray();
        // $trade_collect = collect($trade);

        return view('home.trade-journal', ['trade' => $data->toArray(), 'StartDate' => $StartDate, 'EndDate' => $EndDate]);
    }
    function tradeSummary(Request $req)
    {
        $currentMonth = date('n');
        $currentYear = date('Y');
        $quarterStartMonth = floor(($currentMonth - 1) / 3) * 3 + 1;
        $LatestQuarterDate = date('Y-m-d', mktime(0, 0, 0, $quarterStartMonth, 1, $currentYear));

        $StartDate = (!empty($req->StartDate)) ? $req->StartDate : $LatestQuarterDate; // quarter
        $EndDate = (!empty($req->EndDate)) ? $req->EndDate : date('Y-m-d'); // today

        $data = Expense::whereBetween('Date', [$StartDate, $EndDate])->get();

        $trade = $data->toArray();
        $trade_collect = collect($trade);

        $ExpAmount = $trade_collect->sum('Amount');

        $data = TradeSummary::whereBetween('Date', [$StartDate, $EndDate])->get();

        $trade = $data->toArray();
        $trade_collect = collect($trade);

        $Profit_Loss = $trade_collect->sum('Profit_Loss');
        $STT = $trade_collect->sum('STT');

        return view('home.trade-summary', ['trade' => $trade, 'StartDate' => $StartDate, 'EndDate' => $EndDate, 'Profit_Loss' => $Profit_Loss, 'STT' => $STT, 'Expense' => $ExpAmount]);
    }
    function deleteEntry(Request $req, $TradeID, $Order)
    {
        if ($Order == 'In Process') {
            $delete = TradeJournal::where('Script', $TradeID)
                ->where('Order', 'In Process')
                ->delete();
            $req->session()->put('alert', 'Successfully Deleted Record');
            return redirect('open-trade');
        } elseif ($Order == "Delete") {
            TradeJournal::where('TradeID', $TradeID)
                ->delete();
            TradeSummary::where('TradeID', $TradeID)
                ->delete();
            Expense::where('TradeID', $TradeID)
                ->delete();
            $req->session()->put('alert', "'Successfully Deleted All Record of '.$TradeID'");
            return redirect('open-trade');
        }
        return redirect('open-trade');
    }
}
