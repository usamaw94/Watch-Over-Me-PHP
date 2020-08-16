<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->increments('id');
            $table->string('service_id')->unique();
            $table->string('wearer_id');
            $table->string('customer_id');
            $table->string('wom_num');
            $table->string('service_status');
            $table->integer('no_of_watchers');
            $table->string('wearer_device_token');
            $table->string('customer_device_token');
            $table->string('wearer_logged_in');
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
        Schema::dropIfExists('services');
    }
}
