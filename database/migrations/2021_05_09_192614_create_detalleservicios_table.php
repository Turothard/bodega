<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalleservicios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('servicio_id');
            $table->foreign('servicio_id')->references('id')->on('servicios')->onDelete('cascade');
            $table->date('fechaactivacion');
            $table->string('foliointerno')->nullable();
            $table->string('folioexterno')->nullable();
            $table->unsignedInteger('agencia_id')->nullable();
            $table->foreign('agencia_id')->references('id')->on('agencias')->onDelete('cascade');
            $table->unsignedInteger("responsable_id");
            $table->foreign('responsable_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedInteger("user_id");
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedInteger('area_id');
            $table->foreign('area_id')->references('idarea')->on('areas')->onDelete('cascade');
            $table->unsignedInteger('ubicacion_id')->nullable();
            $table->foreign('ubicacion_id')->references('idubicacion')->on('ubicaciones')->onDelete('cascade');
            $table->string('digitoidentificador')->nullable();
            $table->unsignedInteger('contenido_id')->nullable();
            $table->foreign('contenido_id')->references('id')->on('contenidos')->onDelete('cascade');
            $table->integer('valorinicial');
            $table->integer('valoragregado');
            $table->string('obsvaloragregado');
            $table->integer('valorfinal');
            $table->timestamp('inicio');
            $table->string('fotoinicio')->nullable();
            $table->timestamp('termino')->nullable();
            $table->string('fototermino')->nullable();
            $table->string('observacionservicio')->nullable();
            $table->string('fotoobservacion')->nullable();
            $table->integer('asistentes')->nullable();
            $table->string('estado');
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
        Schema::dropIfExists('detalleservicios');
    }
}
