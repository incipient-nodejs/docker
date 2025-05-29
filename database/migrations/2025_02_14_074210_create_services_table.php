<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Mapper\ConcreteField;
use App\Models\Category;
use App\Models\Service;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(Service::TABLE, function (Blueprint $table) {
            ConcreteField::create($table, function (Blueprint $table) {
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('category_id');
                $table->string('name');
                $table->text('image')->nullable();
                $table->text('video')->nullable();
                $table->string('address')->nullable();
                $table->text('description')->nullable();
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
        Schema::dropIfExists(Service::TABLE);
    }
};
