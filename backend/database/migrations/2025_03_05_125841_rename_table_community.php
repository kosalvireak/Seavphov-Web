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
        Schema::table('cop_members_requests', function (Blueprint $table) {
            $table->dropForeign(['cop_id']); // Drop the foreign key constraint
        });

        Schema::table('cop_members', function (Blueprint $table) {
            $table->dropForeign(['cop_id']); // Drop the foreign key constraint
        });

        // Step 2: Rename the table
        Schema::rename('community', 'communities');

        // Step 3: Recreate the foreign key constraints
        Schema::table('cop_members_requests', function (Blueprint $table) {
            $table->foreign('cop_id')->references('id')->on('communities')->onDelete('cascade');
        });

        Schema::table('cop_members', function (Blueprint $table) {
            $table->foreign('cop_id')->references('id')->on('communities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Step 1: Drop foreign key constraints
        Schema::table('cop_members_requests', function (Blueprint $table) {
            $table->dropForeign(['cop_id']); // Drop the foreign key constraint
        });

        Schema::table('cop_members', function (Blueprint $table) {
            $table->dropForeign(['cop_id']); // Drop the foreign key constraint
        });

        // Step 2: Rename the table back to its original name
        Schema::rename('communities', 'community');

        // Step 3: Recreate the foreign key constraints
        Schema::table('cop_members_requests', function (Blueprint $table) {
            $table->foreign('cop_id')->references('id')->on('community')->onDelete('cascade');
        });

        Schema::table('cop_members', function (Blueprint $table) {
            $table->foreign('cop_id')->references('id')->on('community')->onDelete('cascade');
        });
    }
};
