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
        Schema::create('player_result_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained('games')->onDelete('cascade');
            $table->foreignId('player_result_id')->constrained('player_results')->onDelete('cascade');
            $table->string('player_name');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('player_result_stats', function (Blueprint $table) {
            $table->dropForeign(['game_id']);
            $table->dropForeign(['player_result_id']);
            $table->dropForeign(['player_id']);
        });
        Schema::dropIfExists('player_result_stats');
    }
};
