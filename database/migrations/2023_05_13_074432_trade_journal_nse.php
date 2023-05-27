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
        Schema::create('trade_journal', function (Blueprint $table) {
            $table->string('SchemeID', 20);
            $table->string('userID', 20);// fund manager
            $table->string('TradeID', 100)->nullable()->default('NULL');
            $table->string('Trade', 20)->nullable()->default('NULL');
            $table->string('Order', 20)->nullable()->default('NULL');
            $table->date('Date')->nullable()->default(NULL);
            $table->string('Chart', 20)->nullable()->default('NULL');
            $table->string('Script', 100)->nullable()->default('NULL');
            $table->string('System', 100)->nullable()->default('NULL');
            $table->decimal('Entry', 10, 2)->nullable()->default('0.00');
            $table->decimal('Stop_Loss', 10, 2)->default('0.00');
            $table->decimal('Target1_2', 10, 2)->default('0.00');
            $table->decimal('Target1_3', 10, 2)->default('0.00');
            $table->decimal('Exit', 10, 2)->default('0.00');
            $table->integer('Quantity')->nullable()->default('0');
            $table->decimal('Candle', 5, 2)->nullable()->default('0.00');
            $table->decimal('Risk', 10, 2)->nullable()->default('0.00');
            $table->string('ImageURL')->nullable()->default('NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trade_journal');
    }
};
