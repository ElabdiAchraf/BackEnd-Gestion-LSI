<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->increments('id');
            $table->double('note');
            $table->string('description')->default(null);
            $table->timestamps();
            $table->unsignedInteger('module_id');
            $table->unsignedInteger('etu_id');
            $table->foreign('module_id', 'modules_fk_1001496')->references('id')->on('modules');
            $table->foreign('etu_id', 'etu_fk_1001508')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notes');
    }
}
