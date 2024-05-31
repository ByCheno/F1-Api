<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('results')) {
            Schema::create('results', function (Blueprint $table) {
                $table->id();
                $table->foreignId('race_id')->constrained()->onDelete('cascade');
                $table->foreignId('rider_team_id')->constrained()->onDelete('cascade');
                $table->integer('position');
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('results');
    }
}