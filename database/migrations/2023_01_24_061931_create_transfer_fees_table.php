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
        Schema::create('transfer_fees', function (Blueprint $table) {
            $table->id();
            $table->integer('currency_id');
            $table->integer('country_id');
            $table->double('fees',10,2)->default(0);
            $table->enum('fee_type', ['F','P'])->default('F')->comment('F => Flat, P => Percentage');
            $table->string('title')->nullable();
            $table->longText('description')->nullable();
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
        Schema::dropIfExists('transfer_fees');
    }
};
