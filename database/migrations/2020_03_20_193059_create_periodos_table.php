<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeriodosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();

        Schema::create('periodos', function (Blueprint $table) {
            $table->string('periodo')->unique();
            $table->integer('copiasAsignadas');
            $table->date('finSolicitud');
            $table->date('inicioBeca');
            $table->date('finBeca');
            $table->date('fechaRevision');
            $table->string('responsables');
            $table->date('updated_at');
            $table->date('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('periodos');
    }
}
