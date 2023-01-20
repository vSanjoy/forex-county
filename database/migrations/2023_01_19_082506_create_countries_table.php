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
            $table->string('countryname')->nullable();
            $table->string('countrycode',3)->nullable();
            $table->string('code',2)->nullable();
            $table->string('country_code_for_phone',5)->nullable();
            $table->enum('require_account_holder', ['Y','N'])->default('Y')->comment('N=>No, Y=>Yes');
            $table->enum('require_account_number', ['Y','N'])->default('Y')->comment('N=>No, Y=>Yes');
            $table->enum('require_iban_number', ['Y','N'])->default('N')->comment('N=>No, Y=>Yes');
            $table->enum('require_uk_short_code', ['Y','N'])->default('N')->comment('N=>No, Y=>Yes');
            $table->enum('require_ach_routing_number', ['Y','N'])->default('N')->comment('N=>No, Y=>Yes');
            $table->enum('require_account_type', ['Y','N'])->default('N')->comment('N=>No, Y=>Yes');;
            $table->enum('require_beneficiary_bank', ['Y','N'])->default('Y')->comment('N=>No, Y=>Yes');
            $table->enum('require_ifsc_code', ['Y','N'])->default('N')->comment('N=>No, Y=>Yes');
            $table->enum('require_country', ['Y','N'])->default('N')->comment('N=>No, Y=>Yes');
            $table->enum('require_city', ['Y','N'])->default('N')->comment('N=>No, Y=>Yes');
            $table->enum('require_address', ['Y','N'])->default('N')->comment('N=>No, Y=>Yes');
            $table->enum('require_postal_code', ['Y','N'])->default('N')->comment('N=>No, Y=>Yes');
            $table->string('image')->nullable();
            $table->enum('status', ['0','1'])->default('1')->comment('0=>Inactive, 1=>Active');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'))->nullable();
            $table->softDeletes();
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
