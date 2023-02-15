<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $User= User::orderBy('id','ASC')->get();
        return $User;
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
                'username'=> 'required',
                'email'=> 'required',
                'type'=>'sometimes',
                'perfil'=>'sometimes',
                'password'=>'required',
                //'remember_token'=>'required',
                //'created_at'=>'required',
                //'updated_at'=>'required',
                'foto'=>'sometimes',
                'name'=>'required',                 
            ],[
                'User.before' => 'Campo obrigatório'
            ]);
            $pasta = 'imagem/';
            $url = 'fotos';
            $request->merge(['password'=>bcrypt($request->password)]);
            \File::isDirectory($pasta.$url) or \File::makeDirectory($pasta.$url, 0777, true, true);       
            if(substr($request->file,0,10)=="data:image"){               
    
                $name = time().'.' . explode('/', explode(':', substr($request->file, 0, strpos($request->file, ';')))[1])[1];
                \Image::make($request->file)->save($pasta.$url.'/'.$name);
                $imagens = $url.'/'.$name;                                                     
                $request->merge(['foto'=>$imagens]);
            }
                        
        return User::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $User=User::find($id);
        if($User){
            return response()->json(['status'=>true,'user'=>$User]);
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
        $User = User::findOrFail($id);
        $rules['name']= 'required|string|max:191';
        $rules['Username']= 'required|string|max:20|unique:Users,Username,'.$id;
        $rules['foto']= 'sometimes';
        if(!empty($request->password)){
            $rules['password']= 'sometimes|string|min:6';
            $request->merge(['password' => bcrypt($request['password'])]);
        }else{
            $request->request->remove('password');
        }
        $currentFoto = $User->foto;
        if($request->foto !=""){
            if($request->foto != $currentFoto){
                $name = time().'.' . explode('/', explode(':', substr($request->foto, 0, strpos($request->foto, ';')))[1])[1];
                //\Image::make($request->capa)->save(public_path('../../public_html/img/banners/').$name);
                \Image::make($request->foto)->save(public_path('imagens/').$name);
                $request->merge(['foto' => $name]);
                //$capaImage = public_path('../../public_html/img/banners/').$currentFoto;
                $capaImage = public_path('imagens/').$currentFoto;
                if(file_exists($capaImage)){
                    @unlink($capaImage);
                }
            }
        }else{
            $request->request->remove('foto');
        }


        $this->validate($request,$rules);
        $User->update($request->all());
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
        $User = User::findOrFail($id);
        $User->delete();
        //['message' => 'Registro excluído'];
        return User::all();

    }
}
