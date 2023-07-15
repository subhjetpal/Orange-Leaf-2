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
        Schema::create('expense', function (Blueprint $table) {
            $table->string('SchemeID', 50); // fund manager
            $table->string('UserID', 50);
            $table->string('ExpenseID', 100);
            $table->string('TradeID', 255)->nullable()->default('NULL');
            $table->date('Date')->nullable()->default(NULL);
            $table->string('Category', 20)->nullable()->default('NULL');
            $table->decimal('Amount', 10, 2)->nullable()->default('0.00');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expense');
    }
};
