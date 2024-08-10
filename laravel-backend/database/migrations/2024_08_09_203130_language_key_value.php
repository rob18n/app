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
        Schema::create('language_key_values', function (Blueprint $table) {
            $table->id();
            $table->text('value');
            $table->foreignId('language_id')->constrained()->onDelete('cascade');
            $table->foreignId('language_key_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('language_key_values');
    }
};
