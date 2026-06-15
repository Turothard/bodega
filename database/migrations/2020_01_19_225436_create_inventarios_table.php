<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventarios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("tipoinv");
            $table->string("bodega_id");
            $table->string("estante_id")->nullable();
            $table->date("fechainv");
            $table->string("userinv");
            $table->timestamp("fechainicioinv");
            $table->timestamp("fechafininv")->nullable();
            $table->integer("cantidadbodtotal");
            $table->integer("cantidadinvtotal");
            $table->integer("cantidaddiftotal");
            $table->string("observacioninv")->nullable();
            $table->string("estadoinv");
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
        Schema::dropIfExists('inventarios');
    }
}
