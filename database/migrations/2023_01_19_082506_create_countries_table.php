<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('countrycode',3)->nullable();
            $table->string('countryname')->nullable();
            $table->string('code',2)->nullable();
            $table->string('country_code_for_phone',5)->nullable();
            $table->enum('require_account_holder', ['Y','N'])->default('Y');
            $table->enum('require_account_number', ['Y','N'])->default('Y');
            $table->enum('require_iban_number', ['Y','N'])->default('N');
            $table->enum('require_uk_short_code', ['Y','N'])->default('N');
            $table->enum('require_ach_routing_number', ['Y','N'])->default('N');
            $table->enum('require_account_type', ['Y','N'])->default('N');
            $table->enum('require_beneficiary_bank', ['Y','N'])->default('N');
            $table->enum('require_ifsc_code', ['Y','N'])->default('N');
            $table->enum('require_country', ['Y','N'])->default('N');
            $table->enum('require_city', ['Y','N'])->default('N');
            $table->enum('require_address', ['Y','N'])->default('N');
            $table->enum('require_postal_code', ['Y','N'])->default('N');
            $table->boolean('status')->default(true)->comment('1-Active/0-Inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('countries');
    }
};
