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
        // DB::table('services')->whereNull('rating')->update(['rating' => 0]);
        // Schema::table('services', function (Blueprint $table) {
        //     $table->float('rating')->default(0)->nullable(false)->change();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->float('rating')->nullable()->default(null)->change();
        });
    }
};
