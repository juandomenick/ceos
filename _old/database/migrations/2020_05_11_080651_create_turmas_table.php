<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTurmasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('turmas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('disciplina_id');
            $table->unsignedBigInteger('professor_id');
            $table->string('nome', 50);
            $table->string('sigla', 10);
            $table->year('ano');
            $table->tinyInteger('semestre');
            $table->string('codigo_acesso', 30);
            $table->boolean('ativo')->default(true);
            $table->foreign('disciplina_id')->references('id')->on('disciplinas');
            $table->foreign('professor_id')->references('id')->on('professores');
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
        Schema::dropIfExists('turmas');
    }
}
