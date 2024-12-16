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
        Schema::create('leaderboards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained('games')->onDelete('cascade');
            $table->json('player_result_list')->nullable();
            $table->json('question_leaderboard')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('leaderboards')) {
            Schema::table('leaderboards', function (Blueprint $table) {
                $table->dropForeign(['game_id']);
            });
        }
        Schema::dropIfExists('leaderboards');
    }
};
