<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleTrabajoCamposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalletrabajocampos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('detalleservicio_id');
            $table->foreign('detalleservicio_id')->references('id')->on('detalleservicios')->onDelete('cascade');
            $table->unsignedInteger('detalletrabajo_id');
            $table->foreign('detalletrabajo_id')->references('id')->on('detalletrabajos')->onDelete('cascade');
            $table->unsignedInteger('campotrabajo_id');
            $table->foreign('campotrabajo_id')->references('id')->on('campotrabajos')->onDelete('cascade');
            $table->integer('valor');
            $table->unsignedInteger("user_id");
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('detalletrabajocampos');
    }
}
