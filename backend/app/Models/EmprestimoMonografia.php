<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmprestimoMonografia extends Model
{
    use HasFactory;
    protected $table = 'emprestimomonografia';
    protected $primaryKey ="id";
    protected $fillable = [
    "fk_funcionario",	
    "fk_materiais",	
    ];
}
