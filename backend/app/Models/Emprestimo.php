<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emprestimo extends Model
{
    use HasFactory;
    protected $table = "emprestimos";
    protected $primaryKey = "id";
    protected $fillable = [
    "fk_equipamento",
    "Data",
    "Devolucao",
    "LocalUso",
    "EmailSolicitante",
    ];	
}
