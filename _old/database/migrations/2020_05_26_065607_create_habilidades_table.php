<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHabilidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('habilidades', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('competencia_id');
            $table->string('descricao', 250);
            $table->string('sigla', 10);
            $table->boolean('ativo')->default(true);
            $table->enum('nivel', ['Fácil', 'Intermediário', 'Difícil']);
            $table->foreign('competencia_id')->references('id')->on('competencias');
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
        Schema::dropIfExists('habilidades');
    }
}
