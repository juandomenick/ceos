<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCursosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('instituicao_id');
            $table->unsignedBigInteger('coordenador_id');
            $table->string('nome');
            $table->string('sigla');
            $table->enum('nivel', ['Infantil', 'Fundamental', 'Médio', 'Técnico', 'Graduação', 'Pós-Graduação']);
            $table->boolean('ativo')->default(true);
            $table->foreign('instituicao_id')->references('id')->on('instituicoes');
            $table->foreign('coordenador_id')->references('id')->on('coordenadores');
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
        Schema::dropIfExists('cursos');
    }
}
