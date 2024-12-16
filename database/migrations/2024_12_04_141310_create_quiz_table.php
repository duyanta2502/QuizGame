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
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150)->unique();
            $table->text('description')->nullable();
            $table->string('background_image')->nullable();
            $table->foreignId('creator_id')->constrained('users')->onDelete('cascade');
            $table->integer('points_per_question');
            $table->integer('number_of_questions');
            $table->boolean('is_public')->default(false);
            $table->json('tags')->nullable();
            $table->integer('likes_count')->default(0);
            $table->integer('comments_count')->default(0);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('quizzes')) {
            Schema::table('quizzes', function (Blueprint $table) {
                if (Schema::hasColumn('quizzes', 'creator_id')) {
                    $table->dropForeign(['creator_id']);
                }
            });
        }

        Schema::dropIfExists('quizzes');
    }
};
