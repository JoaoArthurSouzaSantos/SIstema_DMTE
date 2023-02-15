<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
    use HasFactory;
    protected $table = 'professores';
    protected $primaryKey = "id";
    protected $fillable = [
    "name",
    "Titulacao",
    "Situacao",
    "Nivel",
    "Email",
    "Email_Institucional",
    "Lattes",
    ];
}
