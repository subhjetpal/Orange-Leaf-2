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
        Schema::create('lends', function (Blueprint $table) {
            $table->string('SchemeID', 20);
            $table->string('UserID', 20);
            $table->string('CreditID', 20);
            $table->date('Date')->nullable()->default(NULL);
            $table->string('Details', 20)->nullable()->default('NULL');
            $table->decimal('Capital', 10, 2)->nullable()->default('0.00');
            $table->decimal('Rate', 5, 2)->nullable()->default('0.00');
            $table->decimal('EMI', 10, 2)->nullable()->default('0.00');
            $table->integer('Tenure')->nullable()->default('0');
            $table->string('Frequency', 20)->nullable()->default('NULL');
            $table->integer('Repay')->nullable()->default('0');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lends');
        //
    }
};
