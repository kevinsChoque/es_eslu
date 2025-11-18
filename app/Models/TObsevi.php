<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TObsevi extends Model
{
    protected $table='obsevi';
	protected $primaryKey='idOe';
	public $incrementing=false;
	public $timestamps=false;

    protected $fillable = [
        'idOe',
        'idObs',
        'path',
        'date',
        'hour',
    ];
}
