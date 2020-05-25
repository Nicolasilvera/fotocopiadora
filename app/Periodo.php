<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Periodo extends Model
{

	protected $primaryKey = 'periodo';
	protected $keyType = 'string';
	
    protected $fillable = [
    'periodo',
    'copiasAsignadas',
    'finSolicitud',
    'inicioBeca',
    'finBeca',
    'responsables'
	];

}
