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
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->enum('user_type', ['P','B'])->default('P');
            $table->enum('is_email_verified', ['Y','N'])->default('N');
            $table->text('email_verification_code')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('country_code', 50)->nullable();
            $table->enum('is_phone_verified', ['Y','N'])->default('N');
            $table->text('phone_verification_code')->nullable();
            $table->unsignedInteger('country');
            $table->string('city', 150)->nullable();
            $table->string('post_code', 50)->nullable();
            $table->string('building_name')->nullable();
            $table->string('flat_suit')->nullable();
            $table->string('business_country')->nullable();
            $table->string('business_name')->nullable();
            $table->string('company_type')->nullable();
            $table->string('role_in_company')->nullable();
            $table->string('registration_name')->nullable();
            $table->string('website')->nullable();
            $table->string('category')->nullable();
            $table->string('sub_category')->nullable();
            $table->text('business_address')->nullable();
            $table->string('business_city')->nullable();
            $table->string('business_post_code')->nullable();
            $table->enum('is_two_step_verification_active', ['Y','N'])->default('N');
            $table->string('photo_id_proof')->nullable();
            $table->enum('is_photo_id_proof_verified', ['Y','N'])->default('N');
            $table->string('occupation')->nullable();
            $table->string('proof_of_address')->nullable();
            $table->string('proof_of_bank_account_details')->nullable();
            $table->string('proof_of_last_10_transction_in_bank_account')->nullable();
            $table->string('proof_of_money_in_bank_account')->nullable();
            $table->text('fackbook_id')->nullable();
            $table->text('google_id')->nullable();
            $table->enum('is_profile_complete', ['Y','N'])->default('N');
            $table->string('from_currency')->nullable();
            $table->string('to_currency')->nullable();
            $table->string('amount_limit')->nullable();
            $table->string('blockpass_recordid')->nullable();
            $table->string('blockpass_refid')->nullable();
            $table->enum('blockpass_approved', ['Y','N'])->default('N');
            $table->json('blockpass_data')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_details');
    }
};
