<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalLedger extends Model
{
    use HasFactory;
    public $table="journal_ledger";
    public $timestamps = false;
}
