<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TActivation extends Model
{
    protected $table='activation';
	protected $primaryKey='idAct';
	public $incrementing=false;
	public $timestamps=false;

    protected $fillable = [
        'idAct',
        'idCou',
        'idAss',
        'inscription',
        'dateActivation'
    ];
}
