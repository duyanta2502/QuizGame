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
        Schema::create('game_statistics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained('games')->onDelete('cascade');
            $table->json('player_result_list')->nullable();
            $table->float('average_time_per_question')->nullable();
            $table->float('average_points_per_question')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('game_statistics')) {
            Schema::table('game_statistics', function (Blueprint $table) {
                $table->dropForeign(['game_id']);
            });
        }
        Schema::dropIfExists('game_statistics');
    }
};
