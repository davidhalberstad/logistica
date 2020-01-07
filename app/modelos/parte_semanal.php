<?php

namespace App\modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class parte_semanal extends Model
{
	use SoftDeletes;
	
    protected $table = 'parte_semanal';
    protected $primaryKey = 'id_parte_semanal';
}
