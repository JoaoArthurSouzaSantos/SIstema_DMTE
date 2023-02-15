<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Equipamento;
use App\Models\SolicitEquipamento;

class SolicitEquipamentosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $SolicitEquipamento= SolicitEquipamento::orderBy('id','ASC')->get();
        return $SolicitEquipamento;
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
            'fk_User'=> 'required',
            'fk_Equipamento'=> 'required',
        ],
    );
    return SolicitEquipamento::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function Relatorio_Equipamento_func($id)
    {
        $SolicitEquipamento = SolicitEquipamento::where('fk_User',$id)
        ->join('Equipamentos', 'Equipamentos.id', '=', 'fk_Equipamento')
        ->join('Users', 'Users.id', '=', 'fk_User')
        ->select('*','Equipamentos.name as nome_Equipamento')
        ->get();
        return $SolicitEquipamento;
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
