<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTarifariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarifarios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('serviciotrabajo_id');
            $table->foreign('serviciotrabajo_id')->references('id')->on('serviciotrabajos')->onDelete('cascade');
            $table->date('fecha');
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
        Schema::dropIfExists('tarifarios');
    }
}
