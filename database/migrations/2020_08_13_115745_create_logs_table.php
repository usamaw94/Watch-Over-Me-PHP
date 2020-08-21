<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->increments("id");
            $table->string("log_id")->unique();
            $table->string("battery_percentage");
            $table->string("location_latitude");
            $table->string("location_longitude");
            $table->string("locality");
            $table->string("log_text");
            $table->string("log_date");
            $table->string("log_time");
            $table->string("log_type");
            $table->string("service_id");
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
        Schema::dropIfExists('logs');
    }
}
