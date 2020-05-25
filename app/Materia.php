<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
	protected $primaryKey = 'nombre';
	protected $keyType = 'string';
	
    protected $fillable = [
    'nombre',
    'copias'
	];

}
