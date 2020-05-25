<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
	protected $primaryKey = 'id';
	
    protected $fillable = [
    'id',
    'periodo',
    'estudiante',
    'listaMaterias',
    'copiasTotales',
    'copiasOtorgadas',
    'copiasUsadas',
    'categoria',
    'copiasCorregidas'
	];
}
