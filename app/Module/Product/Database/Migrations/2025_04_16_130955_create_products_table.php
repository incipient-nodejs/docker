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
        Schema::connection('mysql_product_api')->create('products_api', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->double('price')->nullable();
            $table->string('category')->nullable();
            $table->string('supplier')->nullable();
            $table->string('link')->nullable();
            $table->text('photo')->nullable();
            $table->string('website')->nullable();
            $table->text('latitude')->nullable();
            $table->text('longitude')->nullable();
            $table->text('rating')->nullable();
            $table->text('promotion')->nullable();
            $table->string('address')->nullable();
            $table->string('email')->nullable();
            $table->text('delivery')->nullable();
            $table->string('market')->nullable();
            $table->text('description')->nullable();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('api_endpoint_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mysql_product_api')->dropIfExists('products_api');
    }
};
