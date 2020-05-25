<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    protected $primaryKey = 'dni';
	
    protected $fillable = [
    'dni',
    'apellido',
    'nombre'
	];
}
