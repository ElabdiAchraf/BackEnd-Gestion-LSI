<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seances', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('jour');
            $table->integer('num')->default(null);
            $table->time('heure_debut');
            $table->time('heure_fin');
            $table->string('description')->default(null);
            $table->timestamps();
            $table->integer('reservation')->default(0); // pour reservetion ==1 sinon 0
            $table->unsignedInteger('module_id')->default(null);
            $table->unsignedInteger('class_id')->default(null);
            $table->foreign('module_id', 'teacher_fk_1001496')->references('id')->on('modules');
            $table->unsignedInteger('salle_id');
            $table->foreign('salle_id', 'class_fk_1001508')->references('id')->on('salles');
            $table->foreign('class_id', 'class_fk_1001508')->references('id')->on('classes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seances');
    }
}
