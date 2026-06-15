<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimientos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("codigoart");
            $table->string("bodegaidori");
            $table->integer("estanteori");
            $table->integer("sectorori");
            $table->integer("nivelori");
            $table->bigInteger("posicionori_id");
            $table->string("bodegaiddes");
            $table->integer("estantedes");
            $table->integer("sectordes");
            $table->integer("niveldes");
            $table->integer("cantidad");
            $table->bigInteger("posiciondes_id");
            $table->string("usermov");
            $table->timestamp("fechamov");
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
        Schema::dropIfExists('movimientos');
    }
}
