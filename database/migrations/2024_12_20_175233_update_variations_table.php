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
        Schema::table('variations', function (Blueprint $table) {

            $table->dropColumn(['variation_type_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('variations', function (Blueprint $table) {
            $table->unsignedBigInteger('variation_type_id');

            $table->foreign('variation_type_id')->references('id')->on('variation_types')->onDelete('cascade');
        });
    }
};
