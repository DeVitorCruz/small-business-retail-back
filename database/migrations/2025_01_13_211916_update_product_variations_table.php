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
        Schema::table('product_variations', function (Blueprint $table) {

            // add column 'variation_type_id' to the `product_variations` table
            $table->unsignedBigInteger('variation_type_id');

            $table->foreign('variation_type_id')->references('id')->on('variation_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_variations', function (Blueprint $table) {

            // drop column 'variation_type_id' to the `product_variations` table
            $table->dropColumn(['variation_type_id']);
        });
    }
};
