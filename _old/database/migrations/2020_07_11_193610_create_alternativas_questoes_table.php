<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlternativasQuestoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alternativas_questoes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('questao_id');
            $table->longText('descricao');
            $table->boolean('alternativa_correta')->default(false);
            $table->foreign('questao_id')->references('id')->on('questoes')->onDelete('cascade');
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
        Schema::dropIfExists('alternativas_questoes');
    }
}
