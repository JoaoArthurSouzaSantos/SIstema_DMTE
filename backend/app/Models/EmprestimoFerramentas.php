<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmprestimoFerramentas extends Model
{
    use HasFactory;
    protected $primaryKey = "id";
    protected $fillable = [
    "fk_funcionario",	
    "fk_ferramentas",	
    ];
}
