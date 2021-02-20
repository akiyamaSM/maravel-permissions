<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraToAbilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('maravel_abilities', function (Blueprint $table) {
            $actions = collect(config('maravels.actions'));
            $entities = collect(config('maravels.entities'))->map(function ($entity) {
                return (string)  \Illuminate\Support\Str::of($entity)->replace("\\", "\\\\");
            });

            if($actions->count() === 0){
                throw new Exception("Not Enough actions");
            }
            $table->enum('action', $actions->toArray())->default($actions->first());
            $table->enum('entity', $entities->toArray())->nullable();
            $table->boolean('is_entity')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('abilities', function (Blueprint $table) {
            $table->dropColumn('action');
            $table->dropColumn('entity');
            $table->dropColumn('is_entity');
        });
    }
}
