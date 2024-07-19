<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRespostasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('respostas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('atividade_designada_id');
            $table->unsignedBigInteger('questao_id');
            $table->unsignedBigInteger('aluno_id');
            $table->foreign('atividade_designada_id')->references('id')->on('atividades_designadas');
            $table->foreign('questao_id')->references('id')->on('questoes');
            $table->foreign('aluno_id')->references('id')->on('alunos');
            $table->string('resposta');
            $table->boolean('resposta_correta')->default(false);
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
        Schema::dropIfExists('respostas');
    }
}
