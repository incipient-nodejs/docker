<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Fix any NULLs to avoid errors
        DB::table('products')->whereNull('rating')->update(['rating' => 0]);

        Schema::table('products', function (Blueprint $table) {
            // Remove precision, fix default, make NOT NULL
            $table->float('rating')->default(0)->nullable(false)->change();
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->float('rating')->nullable()->default(null)->change();
        });
    }
};
