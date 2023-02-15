<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmprestimoMateriaisTable extends Migration
{
    public function up()
    {
        Schema::create('emprestimo_materiais', function (Blueprint $table) {

		$table->integer('id',11);
		$table->timestamp('date_e')->nullable()->default('NULL');
		$table->timestamp('date_d')->nullable()->default('NULL');
		$table->integer('material',11);
		$table->integer('funcionario_E',11);

        });
    }

    public function down()
    {
        Schema::dropIfExists('emprestimo_materiais');
    }
}