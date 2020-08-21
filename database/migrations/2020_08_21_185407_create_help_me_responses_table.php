<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHelpMeResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('help_me_responses', function (Blueprint $table) {
            $table->increments("id");
            $table->string('alert_log_id');
            $table->string('response_from');
            $table->string('response_to');
            $table->string('send_text');
            $table->string('send_date');
            $table->string('send_time');
            $table->string('response_type'); // Yes / No
            $table->string('response_status'); // true / false
            $table->string('reply_text');
            $table->string('reply_date');
            $table->string('reply_time');
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
        Schema::dropIfExists('help_me_responses');
    }
}
