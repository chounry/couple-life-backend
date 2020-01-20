<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->date('dob');
            $table->enum('gender',['male','female', 'other']);
            $table->string('profile_img')->nullable();
            $table->string('cover_img')->nullable();
            $table->boolean('is_creator')->default(false);
            $table->timestamps();

            $table->unsignedInteger('user_type_id');
            $table->unsignedInteger('partner_id')->nullable(); // TODO : delete nullable
            $table->unsignedInteger('login_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
