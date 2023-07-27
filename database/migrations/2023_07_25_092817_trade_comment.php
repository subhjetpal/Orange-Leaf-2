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
        Schema::create('comments', function (Blueprint $table) {
            $table->string('SchemeID', 50); // fund manager
            $table->string('UserID', 50);
            $table->string('TradeID', 255);
            $table->string('CommentID', 20)->nullable()->default('NULL');
            $table->date('Date')->nullable()->default(NULL);
            $table->string('Comment', 20)->nullable()->default('NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
