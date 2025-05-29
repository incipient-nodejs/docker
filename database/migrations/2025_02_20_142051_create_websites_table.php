<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\BusinessDetail;
use App\Mapper\ConcreteField;
use App\Models\Website;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(Website::TABLE, function (Blueprint $table) {
            ConcreteField::create($table, function (Blueprint $table) {
                $table->unsignedBigInteger('business_detail_id');
                $table->string('url');
                $table->boolean('is_integration_api')->default(false);
                $table->string('shop_type');
                $table->foreign('business_detail_id')->references('id')->on(BusinessDetail::TABLE);
                $table->unique(['business_detail_id']);
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(Website::TABLE);
    }
};
