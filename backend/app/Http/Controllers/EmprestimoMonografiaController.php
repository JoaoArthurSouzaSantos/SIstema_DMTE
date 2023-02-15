<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\user;
use App\Models\Monografia;
use App\Models\EmprestimoMonografia;

class EmprestimoMonografiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $EmprestimoMonografia= EmprestimoMonografia::orderBy('id','ASC')->get();
        return $EmprestimoMonografia;
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
            'fk_user'=> 'required',
            'fk_Monografias'=> 'required',
        ],
    );
    return EmprestimoMonografia::create($request->all());
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $EmprestimoMonografia=EmprestimoMonografia::find($id);
        if($EmprestimoMonografia){
            return response()->json(['status'=>true,'EmprestimoMonografia'=>$EmprestimoMonografia]);
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

    public function Relatorio_Monografia_func($id)
    {
        $EmprestimoMonografia = EmprestimoMonografia::where('fk_user',$id)
        ->join('monografias', 'monografias.id', '=', 'fk_monografias')
        ->join('users', 'users.id', '=', 'fk_users')
        ->select('*','Monografias.name as nome_monografia')
        ->get();
        return $EmprestimoMonografia;
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
        $EmprestimoMonografia = EmprestimoMonografia::findOrFail($id);
        $EmprestimoMonografia->delete();
        return EmprestimoMonografia::all();  

    }
}
