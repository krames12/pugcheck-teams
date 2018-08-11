<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CharacterGear extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('character_gear', function(Blueprint $table) {
           $table->increments('id');
           $table->integer('blizz_id');
           $table->integer('character_id');
           $table->string('name');
           $table->integer('item_level');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('character_gear');
    }
}
