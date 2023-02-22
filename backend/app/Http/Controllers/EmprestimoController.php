<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Equipamento;
use App\Models\Emprestimo;
use DB;

class EmprestimoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Emprestimo= Emprestimo::orderBy('id','ASC')->get();
        return $Emprestimo;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,
        [
            'fk_equipamento'=> 'required',
            'Data'=> 'required',
            'Devolucao'=> 'required',
            'LocalUso'=> 'required',
            'EmailSolicitante'=> 'required',
            'fk_user'=> 'required',
        ],
    );
    return Emprestimo::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function Relatorio_Equipamento_func($id)
    {
        $Emprestimo = Emprestimo::where('fk_user',$id)
        ->join('Emprestimos', 'Emprestimos.ids', '=', 'fk_equipamento')
        ->join('users', 'users.id', '=', 'fk_user')
        ->select('*','Emprestimo.name as nome_Equipamento')
        ->get();
        return $Emprestimo;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function dados_graficos()
    {
        $empres = \DB::table('Emprestimo_equipamento')
        ->join('Users', 'Users.id', '=', 'fk_User')
        ->select('fk_User', 'name', DB::raw('COUNT(*) as qtd'))
        ->groupBy('fk_User','name')
        ->orderBy('qtd', 'desc')
        ->limit(5)
        ->get();
        return response()->json($empres);
        //return Emprestimo::groupBy('fk_User')->limit(5)->get();
    }
    
}


