<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('journal_ledger', function (Blueprint $table) {
            $table->string('UserID', 20); // fund manager
            $table->string('JournalID', 100)->nullable()->default('NULL');
            $table->date('Date')->nullable()->default(NULL);
            $table->string('Account_Debit', 100)->nullable()->default('NULL');
            $table->string('Account_Credit', 100)->nullable()->default('NULL');
            $table->decimal('Amount', 10, 2)->nullable()->default('0.00');
            $table->string('Comments', 100)->nullable()->default('NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journal_ledger');
    }
};
