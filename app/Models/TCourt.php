<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TCourt extends Model
{
    protected $table='court';
	protected $primaryKey='idCou';
	public $incrementing=false;
	public $timestamps=false;

    protected $fillable = [
        'idCou',
        'idAss',
        'cargoNro',
        'inscription',
        'dateCourt',
        'coaguaState',
        'codesaState',
    ];
}
