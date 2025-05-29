<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Product;
use App\Models\Service;
use App\Mapper\ConcreteField;
use App\Models\Favorite;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('favorites', function (Blueprint $table) {
            ConcreteField::create($table, function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('service_id')->nullable();
            $table->foreign('user_id')->references('id')->on(User::TABLE);
            $table->foreign('product_id')->references('id')->on(Product::TABLE)->nullable();
            $table->foreign('service_id')->references('id')->on(Service::TABLE)->nullable();
        });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(table: Favorite::TABLE);
    }
};
