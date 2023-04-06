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
        Schema::create('user_pokemon', function (Blueprint $table) {
            $table->id();
            $table->string('pokemon');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('action', ['like', 'hate', 'favorite'])->default('favorite');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_pokemon');
    }
};
