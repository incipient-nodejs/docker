<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\CompanyData;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_contact_counters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('company_data_id');
            $table->string('contact_value');
            $table->string('contact_type');
            $table->integer('counter')->default(1);
            $table->foreign('company_data_id')->references('id')->on(CompanyData::TABLE);
            $table->foreign('user_id')->references('id')->on(User::TABLE);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_contact_counters');
    }
};
