<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Evento;

class EventoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Evento= Evento::orderBy('id','ASC')->get();
        return $Evento;
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
            'name'=> 'required',
            'fk_professor'=> 'required',
            'Titulo'=> 'required',
            'Campus'=> 'required',
            'Link'=> 'required',
            'Tipo'=> 'required',	
        ],[
            'Evento.before' => 'Campo obrigatório'
        ]);
    return Evento::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Evento=Evento::find($id);
        if($Evento){
            return response()->json(['status'=>true,'Evento'=>$Evento]);
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
        $Evento = Evento::findOrFail($id);
        $this->validate($request,[
            'name'=> 'required',
        ]);       
        $Evento->update($request->all());
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
        $Evento = Evento::findOrFail($id);
        $Evento->delete();
        return Evento::all();
    }
}
