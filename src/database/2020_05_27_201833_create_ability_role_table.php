<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbilityRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ability_role', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ability_id');
            $table->unsignedBigInteger('role_id');
            $table->timestamps();

            $table->foreign('ability_id')->references('id')->on('maravel_abilities');
            $table->foreign('role_id')->references('id')->on('maravel_roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ability_role');
    }
}
