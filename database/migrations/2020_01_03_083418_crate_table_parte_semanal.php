<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrateTableParteSemanal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parte_semanal', function (Blueprint $table) {
            $table->bigIncrements('id_parte_semanal');
            $table->integer('id_vehiculo')->unsigned()->references('id_vehiculo')->on('vehiculos');
            $table->integer('id_dependencia')->unsigned()->references('id_dependencia')->on('dependencias');
            $table->string('observaciones_parte');
            $table->integer('id_usuario')->unsigned()->references('id')->on('users');
            $table->softDeletes();
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
        Schema::dropIfExists('parte_semanal');
    }
}
