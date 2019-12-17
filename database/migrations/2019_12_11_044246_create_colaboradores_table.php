<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColaboradoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('colaboradores', function (Blueprint $table) {
            $table->string('rutcolaborador');
            $table->primary('rutcolaborador');
            $table->string('nombrescolab');
            $table->string('apellidoscolab');
            $table->string('nombrecortocolab');
            $table->string('deptocolab');
            $table->string('sectorcolab');
            $table->string('cargocolab');
            $table->date('fechaingresocolab');
            $table->date('fechasalidacolab')->nullable();
            $table->boolean('estadocolab');
            //
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('colaboradores');
    }
}
