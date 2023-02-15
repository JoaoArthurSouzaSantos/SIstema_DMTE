<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipamento extends Model
{
    use HasFactory;
    protected $table = 'equipamentos';
    protected $primaryKey = "id";
    protected $fillable = [
     "estado",
     "name",
     "modelo",
     "marca",
     "file",
     "descricao",			
     "valor",	
    ];
}
