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
        Schema::create('users', function (Blueprint $table) {
            $table->string('UserID', 20);
            $table->string('Name')->nullable()->default('NULL');
            $table->string('User_Type')->nullable()->default('NULL');
            $table->string('Email', 30)->nullable()->default('NULL');
            $table->string('Username', 20);
            $table->string('Password');
            $table->string('ImageURL')->nullable()->default('NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
