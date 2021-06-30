<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePFESTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_f_e_s', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sujet');
            $table->string('description')->default(null);
            $table->timestamps();
            $table->unsignedInteger('prof_id');
            $table->unsignedInteger('etu_id');
            $table->double('note')->default(null);
            $table->date('dateSout')->default(null);
            $table->foreign('prof_id', 'pfe_fk_1001496')->references('id')->on('users');
            $table->foreign('etu_id', 'pfe_fk_1001508')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('p_f_e_s');
    }
}
