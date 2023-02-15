<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{

    protected $table    = 'perfil';
    protected $fillable = ['id', 'perfil'];
    public $incrementing = true;


     public function getPermissoes(){
         return $this->hasMany('App\Models\PerfilPermissao','perfil_id','id');
    }
    public function perfilPermissoes()
    {
        return $this->belongsToMany('App\Models\Permissao','perfil_permissoes');
        //return $this->belongsToMany(ItemInspecao::class, 'manutencao_item_inspecao', 'manutencao_id', 'iteminspecao_id');
    }    
}