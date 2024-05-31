<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToRidersTable extends Migration
{
    public function up()
    {
        Schema::table('riders', function (Blueprint $table) {
            $table->integer('pole_positions')->default(0)->after('nationality');
            $table->integer('wins')->default(0)->after('pole_positions');
            $table->integer('world_championships')->default(0)->after('wins');
        });
    }

    public function down()
    {
        Schema::table('riders', function (Blueprint $table) {
            $table->dropColumn('pole_positions');
            $table->dropColumn('wins');
            $table->dropColumn('world_championships');
        });
    }
}
