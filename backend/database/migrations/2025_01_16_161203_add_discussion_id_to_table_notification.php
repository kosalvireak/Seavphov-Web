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
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropForeign(['book_id']);
                   
            // Drop the book_id column
            $table->dropColumn('book_id');
            
            // Add new columns object_id and type
            $table->unsignedBigInteger('object_id')->nullable()->after('receiver_id');
            $table->string('type')->after('object_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropColumn('object_id');
            $table->dropColumn('type');
            
            // Re-add the book_id column
            $table->unsignedBigInteger('book_id')->after('receiver_id');
            
            // Re-add the foreign key constraint
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
        });
    }
};