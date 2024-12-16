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
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->foreignId('host_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('quiz_id')->constrained('quizzes')->onDelete('cascade');
            $table->string('pin', 10)->unique();
            $table->boolean('is_live')->default(false);
            $table->json('player_list')->nullable();
            $table->timestamp('start_date')->useCurrent();
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('games')) {
            Schema::table('games', function (Blueprint $table) {
                if (Schema::hasColumn('games', 'host_id')) {
                    $table->dropForeign(['host_id']);
                }
                if (Schema::hasColumn('games', 'quiz_id')) {
                    $table->dropForeign(['quiz_id']);
                }
            });
        }
        Schema::dropIfExists('games');
    }
};
