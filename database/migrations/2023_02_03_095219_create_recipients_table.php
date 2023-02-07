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
        Schema::create('recipients', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->string('account_holder_name', 150)->nullable();
            $table->string('email_address')->nullable();
            $table->string('email_verification_code')->nullable();
            $table->string('business_name')->nullable();
            $table->string('ifsc_code')->nullable();
            $table->unsignedInteger('country');
            $table->string('city')->nullable();
            $table->text('address')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('phone_number',50)->nullable();
            $table->string('account_number')->nullable();
            $table->enum('type', ['P','B'])->default('B');
            $table->string('iban_number')->nullable();
            $table->string('ach_routing_number')->nullable();
            $table->enum('account_type', ['C','S'])->nullable()->comment('C - Checking / S - Savings');
            $table->string('beneficiary_bank')->nullable();
            $table->string('beneficiary_bank_code')->nullable();
            $table->unsignedInteger('currency');
            $table->integer('delivery_method')->default(0)->comment('0 - Null / 1 - Bank Deposit / 2 - Cash Pickup / 3 - Swift');
            $table->string('swift_bic')->nullable();
            $table->enum('deleted_by_user', ['Y','N'])->default('N')->comment('Y - Yes / N - No');
            $table->integer('status')->default('1');
            $table->softDeletes();
            $table->timestamps();

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
        Schema::dropIfExists('recipients');
    }
};
