<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitEquipamento extends Model
{
    use HasFactory;
    protected $primaryKey = "ID_SOLICIT";
    protected $fillable = [
    "date_solicit",
    "date_entrega",
    "quantidade",
    ];
}
