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
        Schema::table('vendor__payouts', function (Blueprint $table) {
            $table->dropColumn('payment_id');
            $table->renameColumn('razorpay_payment_id', 'razorpay_payout_id');
            $table->renameColumn('razorpay_signature', 'razorpay_utr');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendor_payouts', function (Blueprint $table) {
            //
        });
    }
};
