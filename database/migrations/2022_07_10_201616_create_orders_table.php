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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string("order_id");
            $table->string('uid');
            $table->string('shid');
            $table->string('pickup_dt');
            $table->string('delivery_dt');
            $table->string('geolocation');
            $table->string('address');
            $table->string('status');
            $table->string('express');
            $table->string('service_type');
            $table->string('total_cost');
            $table->string('quantity');
            $table->string('clothes_types');
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
        Schema::dropIfExists('orders');
    }
};
