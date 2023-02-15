<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Permissao;

class PermissaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(){
        $this->middleware('auth:api');
        $this->paginacao =env('APP_PAGINACAO',null);
    }

    public function index()
    {
        return Permissao::latest()->paginate($this->paginacao);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
                'permissao' => 'required'
            ],[
                //'data_inicio.before' => 'A data n�o pode ser superior a data atual'
            ]);
       
        return Permissao::create($request->all());        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Permissao::findOrFail($id)->get();
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
        $permissao = Permissao::findOrFail($id);
        $this->validate($request,
            [
                'permissao' => 'required'
            ],[
                //'data_inicio.before' => 'A data n�o pode ser superior a data atual'
            ]);
               
        //print_r($request->all());die;
        $permissao->update($request->all());
        return ['message' => 'Registro atualizado'];        
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permissao = Permissao::findOrFail($id);
        $permissao->delete();
        return Permissao::all();        
    }
}

