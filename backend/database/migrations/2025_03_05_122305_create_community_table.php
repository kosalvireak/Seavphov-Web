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
        Schema::create('community', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('route');
            $table->string('profile');
            $table->string('banner');
            $table->text('description');
            $table->boolean('private');
            $table->timestamps();
        });

        Schema::create('cop_members_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('cop_id');
            $table->integer('status');
            $table->timestamps();


            $table->foreign('cop_id')->references('id')->on('community')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('cop_members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('cop_id');
            $table->integer('role');
            $table->timestamps();


            $table->foreign('cop_id')->references('id')->on('community')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('community');
        Schema::dropIfExists('cop_members_requests');
        Schema::dropIfExists('cop_members');
    }
};
