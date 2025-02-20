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
        Schema::table('discussions', function (Blueprint $table) {
            $table->renameColumn('helpful_vote', 'like');
            $table->renameColumn('not_helpful_vote', 'dislike');
        });
        Schema::table('comments', function (Blueprint $table) {
            $table->renameColumn('helpful_vote', 'like');
            $table->renameColumn('not_helpful_vote', 'dislike');
        });
        Schema::table('book_reviews', function (Blueprint $table) {
            $table->renameColumn('helpful_vote', 'like');
            $table->renameColumn('not_helpful_vote', 'dislike');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('discussions', function (Blueprint $table) {
            $table->renameColumn('like', 'helpful_vote');
            $table->renameColumn('dislike', 'not_helpful_vote');
        });
        Schema::table('comments', function (Blueprint $table) {
            $table->renameColumn('like', 'helpful_vote');
            $table->renameColumn('dislike', 'not_helpful_vote');
        });
        Schema::table('book_reviews', function (Blueprint $table) {
            $table->renameColumn('like', 'helpful_vote');
            $table->renameColumn('dislike', 'not_helpful_vote');
        });
    }
};
