<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbilityMarvelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ability_marvel', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ability_id');
            $table->unsignedBigInteger('marvel_id');
            $table->timestamps();

            $table->foreign('ability_id')->references('id')->on('abilities');
            $table->foreign('marvel_id')->references('id')->on('marvels');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ability_marvel');
    }
}
