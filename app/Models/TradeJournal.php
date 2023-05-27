<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TradeJournal extends Model
{
    use HasFactory;
    public $table="trade_journal";
    public $timestamps = false;
}
