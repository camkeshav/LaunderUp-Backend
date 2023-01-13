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
        Schema::create('order_invoices', function (Blueprint $table) {
            $table->id();
            $table->string("invoice_id");
            $table->string("order_id");
            $table->string("uid");
            $table->string("shid");
            $table->string("customer_name");
            $table->string("gst_no");
            $table->string("service_amount");
            $table->string("sgst");
            $table->string("utgst");
            $table->string("cgst");
            $table->string("service_charge");
            $table->string("delivery_charge");
            $table->string("total_amount");
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
        Schema::dropIfExists('order_invoices');
    }
};
