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
        Schema::create('trade_summary', function (Blueprint $table) {
            $table->string('SchemeID', 20);
            $table->string('UserID', 20); // fund manager
            $table->string('TradeID', 100)->nullable()->default('NULL');
            $table->string('Trade', 20)->nullable()->default('NULL');
            $table->string('Transact', 20)->nullable()->default('NULL');
            $table->date('Date')->nullable()->default(NULL);
            $table->string('Script', 100)->nullable()->default('NULL');
            $table->decimal('Entry', 10, 2)->nullable()->default('0.00');
            $table->decimal('Exit', 10, 2)->nullable()->default('0.00');
            $table->integer('Quantity')->nullable()->default('0');
            $table->decimal('Percent', 5, 2)->nullable()->default('0.00');
            $table->decimal('Profit_Loss', 10, 2)->nullable()->default('0.00');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trade_summary');
        //
    }
};
