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
        Schema::create('schemes', function (Blueprint $table) {
            $table->string('SchemeID', 20);
            $table->string('Scheme_Name', 20)->nullable()->default('NULL');
            $table->string('Scheme_Type', 20)->nullable()->default('NULL');
            // $table->integer('Units', 10)->nullable()->default('NULL');
            $table->decimal('Capital', 10, 2)->nullable()->default('0.00');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schemes');
        //
    }
};
