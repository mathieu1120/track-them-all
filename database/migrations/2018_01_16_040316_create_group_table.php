<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('name');
            $table->string('password');
            $table->boolean('active');
            $table->timestamps();
        });

        Schema::create('group_user_maps', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('group_id');
            $table->boolean('active');
            $table->timestamps();
        });

        Schema::create('user_locations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unique();
            $table->string('latitude');
            $table->string('longitude');
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
        Schema::dropIfExists('groups');
        Schema::dropIfExists('group_user_maps');
        Schema::dropIfExists('user_locations');
    }
}
