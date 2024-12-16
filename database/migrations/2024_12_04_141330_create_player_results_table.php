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
        Schema::create('player_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('player_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('game_id')->constrained('games')->onDelete('cascade');
            $table->integer('score');
            $table->json('answers')->nullable();
            $table->timestamps();
        });



    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('player_results')) {
            Schema::table('player_results', function (Blueprint $table) {
                $table->dropForeign(['player_id']);
                $table->dropForeign(['game_id']);
            });
        }
        Schema::dropIfExists('player_results');
    }



};
