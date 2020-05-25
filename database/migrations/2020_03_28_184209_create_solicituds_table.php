<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();

        Schema::create('solicituds', function (Blueprint $table) {
            $table->increments('id');
            $table->string('periodo');
            $table->integer('estudiante');
            $table->string('listaMaterias');
            $table->integer('copiasTotales');
            $table->integer('copiasOtorgadas')->default(0);
            $table->integer('copiasUsadas')->default(0);
            $table->char('categoria', 1)->default('Z');
            $table->integer('copiasCorregidas')->default(0);
            $table->date('updated_at');
            $table->date('created_at');
            $table->foreign('periodo')->references('periodo')->on('periodos')->onDelete('cascade');
            $table->foreign('estudiante')->references('dni')->on('estudiantes')->onDelete('cascade');
            $table->unique( array('periodo','estudiante') );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('solicituds');
    }
}
