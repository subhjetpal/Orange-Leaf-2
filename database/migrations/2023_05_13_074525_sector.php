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
        Schema::create('sector', function (Blueprint $table) {
            $table->string('ScehemID', 20);
            $table->string('Category', 20)->nullable()->default('NULL');
            $table->string('Allocation', 20)->nullable()->default('NULL');
            $table->decimal('Percent', 5, 2)->nullable()->default('0.00');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sector');
        //
    }
};
