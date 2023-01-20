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
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->integer('country_id')->nullable();
            $table->string('currency')->nullable();
            $table->string('three_digit_currency_code',100)->nullable();
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
            $table->text('exchange_rate')->nullable();
            $table->text('available_transfer_option')->nullable()->comment('Keys of the array with comma separated values');
            $table->enum('is_euro_available', ['Y','N'])->default('Y')->comment('N=>No, Y=>Yes');
            $table->text('available_euro_transfer_option')->nullable()->comment('Keys of the array with comma separated values');
            $table->enum('is_usd_available', ['Y','N'])->default('Y')->comment('N=>No, Y=>Yes');
            $table->text('available_usd_transfer_option')->nullable()->comment('Keys of the array with comma separated values');
            $table->string('bank_image')->nullable();
            $table->integer('serial_number')->nullable();
            $table->enum('show_in_sender', ['Y','N'])->default('Y')->comment('N=>No, Y=>Yes');
            $table->enum('show_in_receiver', ['Y','N'])->default('Y')->comment('N=>No, Y=>Yes');
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
        Schema::dropIfExists('currencies');
    }
};
