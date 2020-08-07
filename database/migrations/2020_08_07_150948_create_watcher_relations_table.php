<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWatcherRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('watcher_relations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('svc_id');
            $table->string('watcher_id');
            $table->integer('priority_num');
            $table->string('watcher_status');
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
        Schema::dropIfExists('watcher_relations');
    }
}
