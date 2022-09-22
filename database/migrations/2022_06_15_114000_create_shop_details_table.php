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
        Schema::create('shop_details', function (Blueprint $table) {
            $table->id();
            $table->string('shid')->unique();
            $table->string('shop_name');
            $table->string('shop_address');
            $table->string('shop_phone_no');
            $table->string('operational_hours');
            $table->string('days_open');
            $table->json('image_url');
            $table->string('services_available');
            $table->string('cloth_types');
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
        Schema::dropIfExists('shop_details');
    }
};
