<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('description')->nullable();
            $table->string('lat');
            $table->string('lng');
            $table->dateTime('date_occure');
            $table->enum('repetition',['monthly','yearly']);
            $table->enum('remind_before',['week','day', 'month']);
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
        Schema::dropIfExists('table_events');
    }
}
