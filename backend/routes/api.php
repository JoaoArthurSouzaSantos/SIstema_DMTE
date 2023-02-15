<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;


use App\Http\Controllers\UserController;
use App\Http\Controllers\FuncionarioController;
use App\Http\Controllers\EquipamentoController;
use App\Http\Controllers\SolicitEquipamentosController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\EmprestimoController;
use App\Http\Controllers\EmprestimoMonografiaController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\ReuniaoController;
use App\Http\Controllers\DepreciacaoController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\AtivoImobilizadoController;
use App\Http\Controllers\EmpresasCoaltechController;
use App\Http\Controllers\RelacaoSalarialController;
use App\Http\Controllers\ContratosController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\PermissaoController;

Route::group(['middleware'=>['auth:api']], function (){
    Route::apiResource('perfil', PerfilController::class);
    Route::apiResource('permissao', PermissaoController::class);
    Route::apiResource('User', UserController::class);
    Route::apiResource('Evento', EventoController::class);
    Route::apiResource('Equipamento', EquipamentoController::class);
    Route::apiResource('EmprestimoMonografia', EmprestimoMonografiaController::class);
    Route::apiResource('Emprestimo', EmprestimoController::class);
    Route::apiResource('SolicitEquipamento',SolicitEquipamentosController::class);
    Route::apiResource('Reuniao',ReuniaoController::class);
    Route::apiResource('Professor',ProfessorController::class);
    Route::get('/Relatorio_equipamento/{id}', [SolicitEquipamentosController::class, 'Relatorio_equipamento_func']);
    Route::get('/Relatorio_monografia/{id}', [EmprestimoMonografiaController::class, 'Relatorio_momografia_func']);
    Route::get('/Relatorio_emprestimo/{id}', [EmprestimoController::class, 'Relatorio_emprestimo_func']);
    Route::get('getUsuarios',[PerfilController::class, 'getRoles']);
    Route::get('/dados_graficos', [EmprestimoController::class, 'dados_graficos']); 
});
