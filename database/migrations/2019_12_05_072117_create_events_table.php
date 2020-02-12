<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('description')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->dateTime('date_occure');
            $table->enum('repetition',['monthly','yearly','none']);
            $table->enum('remind_before',['week','day', 'month','none']);
            $table->unsignedInteger('day_amount')->nullable();
            $table->timestamps();

            $table->unsignedInteger('user_id');
            $table->unsignedInteger('event_type_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
