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
        Schema::create('money_transfers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->default('0');
            $table->unsignedBigInteger('bank_account_id')->default('0');
            $table->unsignedBigInteger('recipient_id')->default('0');
            $table->string('transfer_no')->nullable();
            $table->decimal('send_amount', 10, 2)->default('0.00');
            $table->string('send_currency')->nullable();
            $table->unsignedBigInteger('sender_country_id')->default('0');
            $table->unsignedBigInteger('sender_currency_id')->default('0');
            $table->decimal('transfer_fees', 10, 2)->default('0.00');
            $table->float('exchange_rate')->default('0.00');
            $table->decimal('received_amount', 10, 2)->default('0.00');
            $table->string('received_currency')->nullable();
            $table->integer('recipient_currency_id')->default('0');
            $table->string('reference')->nullable();
            $table->text('reference_note')->nullable();
            $table->text('note')->nullable();
            $table->dateTime('transfer_datetime')->nullable();
            $table->string('transactionId')->nullable();
            $table->text('xref_code')->nullable();
            $table->integer('responseCode')->default(10)->comment('0 - Successful / authorised transaction., 2 - Card referred., 4 - Card declined – keep card., 5 - Card declined.');
            $table->string('payment_state')->nullable();
            $table->text('authorisationCode')->nullable();
            $table->text('responseMessage')->nullable();
            $table->timestamp('transaction_time')->nullable();
            $table->text('transfer_bank_reference_id')->nullable();
            $table->text('amount_paid')->nullable();
            $table->string('account_holder_name')->nullable();
            $table->enum('payment_type', ['B','O'])->default('B')->comment('B - Bank Transfer / O - Online Payment');
            $table->enum('payment_status', ['P','U','V'])->default('U')->comment('P - Paid / U - Unpaid / V - Paid but in verification');
            $table->integer('status')->default('0')->comment('0 - Pending / 1 - Completed / 2 - More details required / 3 - Cancelled / 4 - Proceed to pay / 5 - In verification');
            $table->enum('forex_country_transfer_status', ['P','U'])->default('U')->comment('P - Paid / U - Unpaid');
            $table->integer('from_home')->default(0)->comment('0 - Not coming from home page / 1 - From home page');
            $table->integer('transfer_fee_id')->nullable();
            $table->text('reason')->comment('Reason for cancellation or any other status')->nullable();
            $table->softDeletes();
            $table->timestamps();

            //$table->foreign('user_id')->references('id')->on('users');
            //$table->foreign('bank_account_id')->references('id')->on('banks');
            //$table->foreign('recipient_id')->references('id')->on('recipient');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('money_transfers');
    }
};
