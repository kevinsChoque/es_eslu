<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TAssign extends Model
{
    protected $table='assign';
	protected $primaryKey='idAss';
	public $incrementing=false;
	public $timestamps=false;

    protected $fillable = [
        'idAss',
        'idEnd',
        'idTec',
        'month',
        'flat',
        'filter',
        'routes',
        'monthDebt',
        'listCutsOld',
        'cant',
        'dr',
    ];
}
