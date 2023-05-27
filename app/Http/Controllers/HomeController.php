<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TradeJournal;
use App\Models\TradeSummary;
use App\Models\Scheme;
use App\Models\Sector;
use App\Models\Lend;
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
            return view('home.view-trade', ['val' => $data->toArray()]);
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
            // $tb->TradeID = $TradeID;
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
        } elseif ($req->Trade == 'Dividend' and $req->Order == 'Exit') {
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
        }
        return redirect('add-entry');
    }
    function modifyEntryFetch(Request $req, $Order, $TradeID)
    {
        if ($Order == 'In Process') {

            $data = TradeJournal::where('Script', $TradeID)
                ->where('Order', $Order)
                ->first();

            $Entry = $data->Entry;
        } elseif ($Order == 'Open') {

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
        } else {
            $data = TradeJournal::where('TradeID', $TradeID)
                ->where('Order', $Order)
                ->first();

            $Entry = $data->Entry;
        }
        return view('home.modify-entry', ['val' => $data->toArray(), 'Entry' => $Entry]);
    }
    function modifyEntry(Request $req)
    {
        if ($req->Order == 'Open') {

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

            // date format to 10MAR2022
            $DateToText = date('d', strtotime($Date)) . strtoupper(date('M', strtotime($Date))) . date('Y', strtotime($Date));

            // $TradeID = $Script . '_' . $DateToText . '_' . strtoupper($Order);

            $TradeID = strtoupper($req->Script) . '_' . $DateToText . '_' . strtoupper($req->Trade) . '_' . 'ENTRY';

            // Image Upload -----------------------
            $file = $req->file('fileToUpload');
            $fileName = $file->getClientOriginalName();
            $filePath = 'images/' . $fileName;

            if (Storage::exists($filePath)) {
                return redirect('open-trade');
            } else {
                $file->storeAs('images', $fileName, 'public');

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
                        'ImageURL' => $fileName
                    ]);
            }
        } elseif ($req->Order == 'Exit') {
            $Trade =  $req->Trade;
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

            // date format to 10MAR2022
            $DateToText = date('d', strtotime($Date)) . strtoupper(date('M', strtotime($Date))) . date('Y', strtotime($Date));

            $TradeID = $Script . '_' . $DateToText . '_' . strtoupper($Trade) . '_' . strtoupper($Order);
            $TradeID_S = $Script . '_' . $DateToText . '_' . strtoupper($Trade);

            // Image Upload -----------------------
            $file = $req->file('fileToUpload');
            $fileName = $file->getClientOriginalName();
            $filePath = 'images/' . $fileName;

            if (Storage::exists($filePath)) {
                return redirect('open-trade');
            } else {
                $entry = new TradeJournal;

                $entry->UserID = $req->session()->get('user')['UserID'];
                $entry->SchemeID = '23EGD8564';
                $entry->TradeID = $TradeID;
                $entry->Trade = $Trade;
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
                $entry->ImageURL = $fileName;

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
            }
        }

        return redirect('open-trade');
    }
    function tradeJournal(Request $req)
    {
        // fetch all data ---
        $StartDate = (!empty($req->StartDate)) ? $req->StartDate : date('Y') . "-" . str_pad(ceil(date('m', time()) / 3), 2, '0', STR_PAD_LEFT) . "-01"; // quarter
        $EndDate = (!empty($req->EndDate)) ? $req->EndDate : date('Y-m-d'); // today

        // $StartDate=date('d-m-Y',strtotime($StartDate));
        // $EndDate=date('d-m-Y',strtotime($EndDate));

        //$sql = "SELECT * FROM $tb_journal_nse";

        $data = TradeJournal::whereBetween('Date', [$StartDate, $EndDate])->get();

        return view('home.trade-journal', ['trade' => $data->toArray()]);
    }
    function tradeSummary(Request $req)
    {
        // fetch all data ---
        $StartDate = (!empty($req->StartDate)) ? $req->StartDate : date('Y') . "-" . str_pad(ceil(date('m', time()) / 3), 2, '0', STR_PAD_LEFT) . "-01"; // quarter
        $EndDate = (!empty($req->EndDate)) ? $req->EndDate : date('Y-m-d'); // today

        // $StartDate=date('d-m-Y',strtotime($StartDate));
        // $EndDate=date('d-m-Y',strtotime($EndDate));

        // $sql = "SELECT * FROM $tb_summary WHERE `Date` between '$StartDate' and '$EndDate' ";
        //$sql = "SELECT * FROM $tb_summary";

        $data = TradeSummary::whereBetween('Date', [$StartDate, $EndDate])->get();

        return view('home.trade-summary', ['trade' => $data->toArray()]);
    }
    function deleteEntry(Request $req, $TradeID, $Order)
    {
        if (!empty($TradeID) && empty($Order)) {
            $delete = TradeJournal::where('Script', $TradeID)
                ->where('Order', 'In Process')
                ->delete();
        } elseif (!empty($Order) && $Order == "ROOT-J") {
            $delete = TradeJournal::where('TradeID', $TradeID)
                ->delete();
        } elseif (!empty($Order) && $Order == "ROOT-S") {
            $delete = TradeSummary::where('IradeID', $TradeID)
                ->delete();
        }
        return redirect('open-trade');
    }
}
