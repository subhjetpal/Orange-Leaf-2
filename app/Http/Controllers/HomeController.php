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
    static function isActive()
    {
        if (Session::has('user')) {
            return redirect('/login');
        }
        // $userID=Session::get('user')['UserID']; 
        // $trade=DB::table('TradeJournal')
        //     ->join('trade_summary','TradeJournal.date','=','trade_summary.date')
        //     ->where('trdae_summary',$userID)
        //     ->select('trdae_summary.*')
        //     ->get();

        $open = 'open';
        // $data=TradeJournal::all();
        $data = TradeJournal::where('trade', $open);
        // $data=TradeJournal::where('trade',$open)->count();
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

        $journalData = TradeJournal::where('Order', 'Open')
            ->where('Instrument', 'Equity')
            ->get();

        $journalTrade = $journalData->toArray();
        $tradeCollect = collect($journalTrade);

        $InMktRisk = $tradeCollect->sum('Risk');

        $summaryData = TradeSummary::where('Instrument', 'Options')->get();

        $summaryTrade = $summaryData->toArray();
        $summaryCollect = collect($summaryTrade);

        $turnOver = $summaryCollect->sum('Profit_Loss');

        $Capital = Scheme::where('SchemeID', '23EGD8564')->first();
        $equityCap = $Capital->Capital * 0.8;

        $Capital = Scheme::where('SchemeID', '23TRA7546')->first();
        $intraCap = $Capital->Capital * 1.0;

        // $Allocation = Sector::where('SchemeID','23TRA7546')
        // ->where()
        // ->get();

        $equityRisk = $equityCap * 0.01;
        $intraRisk = $intraCap * 0.005;

        $equityTotalRisk = $equityCap * 0.1;
        $intraTotalRisk = $intraCap * 0.05;

        $riskPossibleEquity = $equityTotalRisk - $InMktRisk;
        $riskPossibleIntra = $intraTotalRisk + $turnOver;

        $tradePossibleEquity = $riskPossibleEquity / $equityRisk;
        $tradePossibleIntra = $riskPossibleIntra / $intraRisk;

        return view('home.risk-factor', [
            'equityCap' => $equityCap,
            'InMktRisk' => $InMktRisk,
            'equityTotalRisk' => $equityTotalRisk,
            'riskPossibleEquity' => $riskPossibleEquity,
            'tradePossibleEquity' => round($tradePossibleEquity,2),
            // --------------------------------------------
            'intraCap' => $intraCap,
            'turnOver' => $turnOver,
            'intraTotalRisk' => $intraTotalRisk,
            'riskPossibleIntra' => $riskPossibleIntra,
            'riskPossibleIntra' => $riskPossibleIntra,
            'tradePossibleIntra' => round($tradePossibleIntra,2)
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
            return view('home.view-trade', ['val' => $data->toArray(), 'Comment'=>$Comment]);
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
        } elseif ($req->Trade == 'Intraday') {
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
            $Charges = 40;

            if ($Type == 'Options') {
                $STT = (($Order == 'Buy') ? $Exit : $Entry) * $Quantity * 0.000625;
            } elseif ($Type == 'Equity') {
                $STT = (($Order == 'Buy') ? $Exit : $Entry) * $Quantity * 0.00025;
            }

            // date format to 10MAR2022
            $DateToText = date('d', strtotime($Date)) . strtoupper(date('M', strtotime($Date))) . date('Y', strtotime($Date));

            $TradeID = $Script . '_' . $DateToText . '_' . strtoupper($Trade) . '_' . strtoupper($Order);

            $numRows = TradeJournal::where('TradeID', 'LIKE', $TradeID . '%')
                ->count();
            $TradeID = $numRows > 0 ? $TradeID . $numRows + 1 : $TradeID;
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

                $expense->save();

                $req->session()->put('alert', 'Successfully Recorded Intraday Order');
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
            $TradeID = 'NULL';
        } elseif ($Order == 'Open' && $stage == "Upgrade") {

            $data = TradeJournal::where('TradeID', $TradeID)
                ->where('Order', $Order)
                ->first();

            $Script = $data->Script;
            $Trade = $data->Trade;

            $avgEntry = TradeJournal::selectRaw('AVG(Entry) as avg_entry')
                ->whereIn('TradeID', function ($query) use ($Script, $Trade, $Order) {
                    $query->select('TradeID')
                        ->from((new TradeJournal)->getTable())
                        ->where('Script', $Script)
                        ->where('Order', $Order)
                        ->where('Trade', $Trade);
                })
                ->first();
            $Entry = $avgEntry->avg_entry;
            $TradeID = 'NULL';
        } elseif ($Order == 'Open' && $stage == "Edit") {

            $data = TradeJournal::where('TradeID', $TradeID)
                ->where('Order', $Order)
                ->first();

            $Entry = $data->Entry;
            $TradeID = $data->TradeID;
        } elseif ($Order == 'Exit' && $stage == "Edit") {

            $data = TradeJournal::where('TradeID', $TradeID)
                ->where('Order', $Order)
                ->first();

            $Entry = $data->Entry;
            $TradeID = $data->TradeID;
        } else {
            $data = TradeJournal::where('TradeID', $TradeID)
                ->where('Order', $Order)
                ->first();

            $Entry = $data->Entry;
            $TradeID = $data->TradeID;
        }
        return view('home.modify-entry', ['val' => $data->toArray(), 'Entry' => $Entry, 'TradeID' => $TradeID]);
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
                        'ImageURL' => $filePath
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

            $EntrySTT = $Entry * $Quantity * 0.001;
            $ExitSTT = $Exit * $Quantity * 0.001;

            $STT = $EntrySTT + $ExitSTT;

            // date format to 10MAR2022
            $DateToText = date('d', strtotime($Date)) . strtoupper(date('M', strtotime($Date))) . date('Y', strtotime($Date));

            $TradeID = $Script . '_' . $DateToText . '_' . strtoupper($Trade) . '_' . strtoupper($Order);
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
                $entry = new TradeJournal;

                $entry->UserID = $req->session()->get('user')['UserID'];
                $entry->SchemeID = '23EGD8564';
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

                $entry = TradeJournal::where('Script', $Script)
                    ->where('Order', 'Open')
                    ->where('Trade', $Trade)
                    ->update(['Order' => 'Entry']);

                $Transact = ($Entry > $Stop_Loss) ? 'Buy' : 'Short';

                if ($Transact == 'Buy') {
                    $Percent = ($Exit - $Entry) * 100 / $Entry;
                } else {
                    $Percent = ($Entry - $Exit) * 100 / $Entry;
                }
                $Profit_Loss = (($Transact == 'Buy') ? ($Exit - $Entry) : ($Entry - $Exit)) * $Quantity;

                $summary = new TradeSummary;

                $summary->UserID = $req->session()->get('user')['UserID'];
                $summary->SchemeID = '23EGD8564';
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
                $seconds_value = date("s");
                $ExpenseID = $today_date . 'D' . $seconds_value;

                if ($Type == 'Equity') {
                    $Charges = ($Trade == 'Swing') ? 15.93 : 23.60;
                } else {
                    $Charges = 0;
                }

                $expense = new Expense;

                $expense->UserID = $req->session()->get('user')['UserID'];
                $expense->SchemeID = '23TRA7546';
                $expense->ExpenseID = $ExpenseID;
                $expense->TradeID = $TradeID;
                $expense->Date = $Date;
                $expense->Instrument = $Type;
                $expense->Amount = $Charges;

                $expense->save();

                $req->session()->put('alert', 'Successfully Upgraded to Exit Order');
                return redirect('open-trade');
            }
        } elseif (($req->Order == 'Open' || $req->Order == 'Entry') && $req->TradeID != "NULL") {
            $Trade =  strtoupper($req->Trade);
            // $Order =  $req->Order;
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

                $entry = TradeJournal::where('Script', $Script)
                    ->where('TradeID', $req->TradeID)
                    ->update([
                        'TradeID' => $TradeID,
                        // 'Order' => $Order,
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
                        'ImageURL' => $filePath
                    ]);

                $req->session()->put('alert', 'Successfully Edited Recorded Open Order');
                return redirect('open-trade');
            }
        } elseif ($req->Order == 'Exit' && $req->TradeID != "NULL") {
            $Trade =  $req->Trade;
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

            $EntrySTT = $Entry * $Quantity * 0.001;
            $ExitSTT = $Exit * $Quantity * 0.001;

            $STT = $EntrySTT + $ExitSTT;

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
                        'TradeID' => $TradeID,
                        // 'Order' => $Order,
                        'Date' => $Date,
                        'System' => $System,
                        'Entry' => $Entry,
                        'Exit' => $Exit,
                        'Quantity' => $Quantity,
                        'Candle' => $Candle,
                        'Risk' => $Risk,
                        'STT' => $ExitSTT,
                        'ImageURL' => $filePath
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
                        'TradeID' => $TradeID,
                        'Trade' => $Trade,
                        'Transact' => $Transact,
                        'Date' => $Date,
                        'Script' => $Script,
                        'Entry' => $Entry,
                        'Exit' => $Exit,
                        'Quantity' => $Quantity,
                        'STT' => $STT,
                        'Percent' => $Percent,
                        'Profit_Loss' => $Profit_Loss
                    ]);

                $req->session()->put('alert', 'Successfully Edited Recorded Exit Order');
                return redirect('open-trade');
            }
        }
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
        } elseif ($Order == "ROOT-J") {
            $delete = TradeJournal::where('TradeID', $TradeID)
                ->delete();
        } elseif ($Order == "ROOT-S") {
            $delete = TradeSummary::where('TradeID', $TradeID)
                ->delete();
        }
        return redirect('open-trade');
    }
}
