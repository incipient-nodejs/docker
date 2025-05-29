<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\BusinessDetail;
use App\Mapper\ConcreteField;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(BusinessDetail::TABLE, function (Blueprint $table) {
            ConcreteField::create($table, function (Blueprint $table) {
                $table->unsignedBigInteger('user_id');
                $table->string('category');
                $table->string('phone_preference');
                $table->string('phone');
                $table->string('whatsapp')->nullable();
                $table->string('email')->nullable();
                $table->string('website_url')->nullable();
                $table->boolean('is_sell_product')->default(false);
                $table->foreign('user_id')->references('id')->on(User::TABLE);
                $table->unique(['user_id']);
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(BusinessDetail::TABLE);
    }
};
