<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RosterCharacters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roster_characters', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('roster_id');
            $table->string('character_id');
            $table->enum('main_spec', ['tank', 'healer', 'rdps', 'mdps']);
            $table->enum('off_spec', ['tank', 'healer', 'rdps', 'mdps']);
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
        Schema::drop('roster_characters');
    }
}
