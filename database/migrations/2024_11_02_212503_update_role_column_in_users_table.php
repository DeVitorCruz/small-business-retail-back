<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            // Update existing to new numeric representation
            DB::table('users')->where('role', 'owner')->update(['role' => 1]);
            DB::table('users')->where('role', 'employee')->update(['role' => 2]);
            DB::table('users')->where('role', 'seller')->update(['role' => 3]);
            DB::table('users')->where('role', 'customer')->update(['role' => 4]);

            // Modify the `role` column to be an integer instead of enum
            Schema::table('users', function (Blueprint $table) {
                $table->integer('role')->default(4)->change();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Rollback the `role` column back to ENUM with origianl values
            Schema::table('users', function (Blueprint $table) {
                $table->enum('role', ['owner', 'employee', 'seller', 'customer']);
            });

            // Revert numeric values back to strings

            DB::table('users')->where('role', 1)->update(['role' => 'owner']);
            DB::table('users')->where('role', 2)->update(['role' => 'employee']);
            DB::table('users')->where('role', 3)->update(['role' => 'seller']);
            DB::table('users')->where('role', 4)->update(['role' => 'customer']);
        });
    }
};
