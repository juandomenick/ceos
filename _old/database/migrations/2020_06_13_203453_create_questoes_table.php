<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questoes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('professor_id');
            $table->unsignedBigInteger('habilidade_id');
            $table->longText('descricao');
            $table->integer('pontos');
            $table->integer('tempo_minimo');
            $table->integer('tempo_maximo');
            $table->boolean('ativo')->default(true);
            $table->enum('nivel', ['Fácil', 'Intermediário', 'Difícil']);
            $table->enum('tipo', ['Alternativa', 'Complete', 'Dissertativa', 'Ordenação', 'Quizz', 'Sócio Econômico']);
            $table->foreign('professor_id')->references('id')->on('professores');
            $table->foreign('habilidade_id')->references('id')->on('habilidades');
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
        Schema::dropIfExists('questoes');
    }
}
