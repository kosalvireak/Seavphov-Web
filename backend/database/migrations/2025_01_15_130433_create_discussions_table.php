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
        Schema::create('discussions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('owner_id');
            $table->mediumText('body');
            $table->string('image');
            $table->integer('comments');
            $table->integer('helpful_vote');
            $table->integer('not_helpful_vote');
            $table->timestamps();

                        
            // Define foreign key constraints
            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('owner_id');
            $table->unsignedBigInteger('discussion_id');
            $table->mediumText('body');
            $table->integer('helpful_vote');
            $table->integer('not_helpful_vote');
            $table->timestamps();

                        
            // Define foreign key constraints
            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('discussion_id')->references('id')->on('discussions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discussions');
        Schema::dropIfExists('comments');
    }
};