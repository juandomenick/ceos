<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAtividadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atividades', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('professor_id');
            $table->unsignedBigInteger('disciplina_id');
            $table->enum('tipo', ['Avaliação Impressa', 'Questionário', 'Simulado']);
            $table->enum('nivel', ['Iniciante', 'Inteligência Múltiplas', 'Sócio Econômico - Adulto', 'Sócio Ecoômico - Infantil']);
            $table->enum('visualizacao', ['Total', 'Individual']);
            $table->integer('pontos');
            $table->integer('tempo_minimo');
            $table->integer('tempo_maximo');
            $table->text('metodo_avaliacao');
            $table->text('descricao');
            $table->boolean('ativo')->default(true);
            $table->foreign('professor_id')->references('id')->on('professores');
            $table->foreign('disciplina_id')->references('id')->on('disciplinas');
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
        Schema::dropIfExists('atividades');
    }
}
