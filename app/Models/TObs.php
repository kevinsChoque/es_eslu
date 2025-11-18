<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TObs extends Model
{
    protected $table='obs';
	protected $primaryKey='idObs';
	public $incrementing=false;
	public $timestamps=false;

    protected $fillable = [
        'idObs',
        'idAss',
        'inscription',
        'comment'
    ];
}
