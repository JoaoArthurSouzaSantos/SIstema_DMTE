<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmprestimoFerramentasTable extends Migration
{
    public function up()
    {
        Schema::create('emprestimo_ferramentas', function (Blueprint $table) {

		$table->integer('id',11);
		$table->timestamp('date_E')->nullable()->default('NULL');
		$table->timestamp('date_D')->nullable()->default('NULL');
		$table->integer('func_id_estr',11);
		$table->integer('ferramenta',11);

        });
    }

    public function down()
    {
        Schema::dropIfExists('emprestimo_ferramentas');
    }
}