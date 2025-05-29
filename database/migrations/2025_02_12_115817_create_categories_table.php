<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Mapper\ConcreteField;
use App\Models\Category;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(Category::TABLE, function (Blueprint $table) {
            ConcreteField::create($table, function (Blueprint $table) {
                $table->string('code')->nullable();
                $table->string('name')->unique();
                $table->integer('order')->default(0);
                $table->text('icon')->nullable();
                $table->string('description')->nullable();
                $table->string('type');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(Category::TABLE);
    }
};
