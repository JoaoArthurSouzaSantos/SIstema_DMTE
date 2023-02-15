<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Perfil;
use App\Models\PerfilPermissao;
use DB;

class PerfilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(){
        $this->middleware('auth:api')->except(['getRoles']);
        $this->paginacao=env('APP_PAGINACAO',null);
    }

    public function index()
    {
        return Perfil::latest()
        ->with("getPermissoes")
        ->with("perfilPermissoes")
        ->paginate($this->paginacao);
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
        // return $request->all();
        //$dados['permissoes'] = $request->permissao;
        //$request->request->remove('permissao');
        $this->validate($request,
            [
                'perfil' => 'required'
            ],[
                //'data_inicio.before' => 'A data n�o pode ser superior a data atual'
            ]);
       //perfilPermissoes $user->roles()->sync([1, 2, 3]);
       $dados=[];        
       if($request->permissao){
           foreach($request->permissao as $k=>$val){
               $dados[] = array('permissao_id'=>$val);
           }
       }
    //    return $dados;
       $request->request->remove('permissao');
    //    return $request->all();
       $perfil = Perfil::create($request->all());        
       $perfil->perfilPermissoes()->sync($dados);
       
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
        $perfil = Perfil::findOrFail($id);
        $this->validate($request,
            [
                'perfil' => 'required'
            ],[
                //'data_inicio.before' => 'A data n�o pode ser superior a data atual'
            ]);
               
        //return $request->id;die;
        $dados=[];        
        //return $request->permissao;
        if($request->permissao){
            foreach($request->permissao as $k=>$val){
                $dados[] = array('permissao_id'=>$val);
            }
        }          
        $request->request->remove('permissao');        
        $perfil->update($request->all());

        $perfilP = PerfilPermissao::where('perfil_id',$request->id);
        $perfilP->delete();               
        $perfil->perfilPermissoes()->sync($dados);
        return ['message' => 'Registro atualizado'];        
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Perfil::findOrFail($id)->get();
    }

    public function getRoles()
    {
        $dados = \Auth::user();
        //return $dados->perfil;
        $perfis = DB::table('perfil_permissoes')
            ->where('perfil_id',$dados->perfil)
            ->join("permissoes","permissoes.id","=","permissao_id")
            ->get();
        $permissoes = [];
        foreach ($perfis as $key => $value) {
            $permissoes[$value->permissao] = $value->permissao;
        }
        $dados['permissoes'] = $permissoes;
        return $dados;
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $perfil = Perfil::findOrFail($id);
        $perfil->delete();
        return Perfil::all();        
    }
}
