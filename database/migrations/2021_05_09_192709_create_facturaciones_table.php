<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturaciones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamp('fechainicio');
            $table->timestamp('fechatermino');
            $table->unsignedInteger("user_id");
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('mesfacturacion');
            $table->integer('netototal');
            $table->integer('ivatotal');
            $table->integer('brutofinal');
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
        Schema::dropIfExists('facturaciones');
    }
}
