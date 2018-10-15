<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBonusIdsToCharacterGearTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('character_gear', function (Blueprint $table) {
            $table->json('bonus_ids')->after('item_level');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('character_gear', function (Blueprint $table) {
            $table->dropColumn('bonus_ids');
        });
    }
}
