<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Mapper\ConcreteField;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(Product::TABLE, function (Blueprint $table) {
            ConcreteField::create($table, function (Blueprint $table) {
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('category_id');
                $table->string('name');
                $table->text('image')->nullable();
                $table->text('image_traseiro')->nullable();
                $table->text('image_esquerda')->nullable();
                $table->text('image_direita')->nullable();
                $table->text('video')->nullable();
                $table->text('description')->nullable();
                $table->string('address')->nullable();
                $table->double('price');
                $table->integer('min_qtd')->unsigned()->nullable();
                $table->boolean('promotion')->default(false);
                $table->boolean('delivery')->default(false);
                $table->double('rating')->nullable();
                $table->integer('counter_view')->default(0);
                $table->foreign('user_id')->references('id')->on(User::TABLE);
                $table->foreign('category_id')->references('id')->on(Category::TABLE);
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(table: Product::TABLE);
    }
};
