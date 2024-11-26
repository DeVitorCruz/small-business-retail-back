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
        Schema::table('sub_categories', function (Blueprint $table) {

            // Drop the existing foreign key constraint, if any
            $table->dropForeign(['category_id']);


            // Modify the column to add the foreign key with cascade delete
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sub_categories', function (Blueprint $table) {

            // Drop the newly added foreign key constraint
            $table->dropForeign(['category_id']);

            // Revert to the previous state withou cascade delete
            $table->foreign(['category_id'])
                ->references('id')
                ->on('categories');
        });
    }
};
