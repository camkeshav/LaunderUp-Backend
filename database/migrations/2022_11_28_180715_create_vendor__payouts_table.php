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
        Schema::create('vendor__payouts', function (Blueprint $table) {
            $table->id()->unique();
            // $table->string('payment_id')->unique();
            $table->string('total_amount');
            $table->string('razorpay_payout_id')->nullable();
            $table->string('razorpay_utr')->nullable();
            $table->string('shid');
            $table->string('status');
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
        Schema::dropIfExists('vendor__payouts');
    }
};
