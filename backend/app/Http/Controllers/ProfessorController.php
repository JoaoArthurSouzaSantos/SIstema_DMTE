<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Professor;



class ProfessorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Professor= Professor::orderBy('id','ASC')->get();
        return $Professor;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->validate($request,
        [
            'name'=> 'required',
            'Titulacao'=> 'required',
            'Situacao'=>'required',
            'Nivel'=>'required',
            'Email'=>'required',
            'Email_Institucional'=>'required',
            'Lattes'=>'required',
        ],[
            'Professor.before' => 'Campo obrigatório'
        ]);
    return Professor::create($request->all()); 

    }

    public function lista_Professors()
    {
        $Professor = Professor::leftJoin('setores', 'setores.id', '=', 'fk_setor')
        ->leftJoin('funcoes', 'funcoes.id', '=', 'fk_funcao')
        ->leftJoin('empresas_coaltech', 'empresas_coaltech.id', '=', 'fk_empresas_coaltech')
        ->select('*','Professors.id','Professors.name','funcoes.name as nome_funcao','setores.name as nome_setor','empresas_coaltech.name as nome_empresas')
        ->get();
        return $Professor;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Professor=Professor::find($id);
        if($Professor){
            return response()->json(['status'=>true,'Professor'=>$Professor]);
        }else{
            return response()->json(['status'=>false]);
        }
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
}
