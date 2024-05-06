<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Scheb\YahooFinanceApi\ApiClient;

class StockAPIController extends Controller
{
    function addJournal(Request $req)
    {

            // date format to 10MAR2022
            $DateToText = date('d', strtotime($req->Date)) . strtoupper(date('M', strtotime($req->Date))) . date('Y', strtotime($req->Date));

            $JournalID = $req->Account_Debit . '_' . $DateToText . '_' . $req->Account_Credit;

            $tb = new JournalLedger;

            $tb->UserID = $req->session()->get('user')['UserID'];
            $tb->JournalID = $JournalID;
            $tb->Date = $req->Date;
            $tb->Account_Debit = $req->Account_Debit;
            $tb->Account_Credit = $req->Account_Credit;
            $tb->Amount = $req->Amount;
            $tb->Comments = $req->Comments;
            $tb->save();

            $req->session()->put('alert', 'Successfully Recorded Journal');
        
        return redirect('add-journal');
    }
}