<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;
    protected $table = "eventos";
    protected $primaryKey = "id";
    protected $fillable = [
    "name",
    "fk_professor",
    "Titulo",
    "Campus",
    "Link",
    "Tipo",							
    ];
}
