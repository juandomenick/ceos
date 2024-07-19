<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnotacoesAulaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anotacoes_aula', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('professor_id');
            $table->unsignedBigInteger('turma_id');
            $table->string('aluno');
            $table->string('descricao');
            $table->date('data');
            $table->time('hora');
            $table->string('assinatura');
            $table->foreign('professor_id')->on('professores')->references('id');
            $table->foreign('turma_id')->on('turmas')->references('id');
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
        Schema::dropIfExists('anotacoes_aula');
    }
}
