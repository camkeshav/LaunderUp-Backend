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
        Schema::create('shop_documents', function (Blueprint $table) {
            $table->id();
            $table->string('shid');
            $table->timestamp('verified_at')->nullable();
            $table->boolean('gst_registered');
            $table->boolean('five_percent_gst');
            $table->string('gst_number');
            $table->string('pan_number');
            $table->string('entity_name');
            $table->string('address_legal_entity');
            $table->string('pan_image_url');
            $table->string('shop_license_number');
            $table->string('shop_license_image_url');
            $table->string('bank_name');
            $table->string('bank_account_number');
            $table->string('ifsc_code');
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
        Schema::dropIfExists('shop_documents');
    }
};
