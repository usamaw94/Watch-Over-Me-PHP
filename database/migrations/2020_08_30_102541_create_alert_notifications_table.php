<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlertNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alert_notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('alert_log_id');
            $table->string('service_id');
            $table->string('wearer_id');
            $table->string('wearer_name');
            $table->string('alert_log_date');
            $table->string('alert_log_time');
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
        Schema::dropIfExists('alert_notifications');
    }
}
