<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reuniao;

class ReuniaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Reuniao= Reuniao::orderBy('id','ASC')->get();
        return $Reuniao;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
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
            'Pauta'=> 'required',
            'Tipo'=> 'required',
            'Link'=> 'required',
            'Local'=> 'required',
            			
        ],[
            'Reuniao.before' => 'Campo obrigatório'
        ]);
    return Reuniao::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Reuniao=Reuniao::find($id);
        if($Reuniao){
            return response()->json(['status'=>true,'Reuniao'=>$Reuniao]);
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
        $Reuniao = Reuniao::findOrFail($id);
        $this->validate($request,[
            'name'=> 'required',
            'valor'=> 'sometimes',
            'marca'=> 'required',
            'descricao'=> 'required',
        ]);       
        $Reuniao->update($request->all());
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
        $Reuniao = Reuniao::findOrFail($id);
        $Reuniao->delete();
        return Reuniao::all();  
    }
}
