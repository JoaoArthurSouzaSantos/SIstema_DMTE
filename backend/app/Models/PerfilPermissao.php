<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class PerfilPermissao extends Model
{

    protected $table    = 'perfil_permissoes';
    protected $fillable =['perfil_id','permissao_id'];
}