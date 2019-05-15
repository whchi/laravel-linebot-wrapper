<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLineBotSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('line_bot_sessions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id', 40)->nullable()->unique();
            $table->string('group_id', 40)->nullable()->unique();
            $table->string('room_id', 40)->nullable()->unique();
            $table->string('session_type', 10);
            $table->integer('last_activity');
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
        Schema::dropIfExists('line_bot_sessions');
    }
}
