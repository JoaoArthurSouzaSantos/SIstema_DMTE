<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Equipamento;

class EquipamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Equipamento= Equipamento::orderBy('id','ASC')->get();
        return $Equipamento;
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
            'estado'=> 'required',
            'name'=> 'required',
            'modelo'=> 'required',
            'file'=>'sometimes',
            'marca'=>'sometimes',
            'descricao'=>'sometimes',
            'valor'=>'sometimes',
        ],[
            'usuario.before' => 'Campo obrigatório'
        ]);
        $pasta = 'imagem/';
        $url = 'fotos';

        \File::isDirectory($pasta.$url) or \File::makeDirectory($pasta.$url, 0777, true, true);       
        if(substr($request->file,0,10)=="data:image"){               

            $name = time().'.' . explode('/', explode(':', substr($request->file, 0, strpos($request->file, ';')))[1])[1];
            \Image::make($request->file)->save($pasta.$url.'/'.$name);
            $imagens = $url.'/'.$name;                                                     
            $request->merge(['file'=>$imagens]);
        }
              
    return Equipamento::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Equipamento=Equipamento::find($id);
        if($Equipamento){
            return response()->json(['status'=>true,'Equipamento'=>$Equipamento]);
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
        $Equipamento = Equipamento::findOrFail($id);
        $this->validate($request,[
            'estado'=> 'required',
            'name'=> 'required',
            'modelo'=> 'required',
            'valor'=> 'required',
            'file'=>'required',
            'marca'=>'required',
        ]);       
        $Equipamento->update($request->all());
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
        $Equipamento = Equipamento::findOrFail($id);
        $epi->delete();
        return epi::all();
    }
}
