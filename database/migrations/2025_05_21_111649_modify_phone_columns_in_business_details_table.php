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
        Schema::table('business_details', function (Blueprint $table) {
            $table->string('phone')->nullable()->default(null)->change();
            $table->string('phone_preference')->nullable()->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('business_details', function (Blueprint $table) {
            $table->string('phone')->nullable(false)->default('')->change(); // or previous settings
            $table->string('phone_preference')->nullable(false)->default('')->change();
        });
    }
};
