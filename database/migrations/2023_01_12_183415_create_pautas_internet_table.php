<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pautas_internet', function (Blueprint $table) {
            $table->id();
            $table->date('fec_pauta');
            $table->string('des_titular');
            $table->text('des_resumen');
            $table->text('des_ruta_web');
            $table->string('des_ruta_imagen');
            $table->string('des_ruta_video');
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
        Schema::dropIfExists('pautas_internet');
    }
};
