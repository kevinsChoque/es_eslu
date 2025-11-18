<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TEvidence extends Model
{
    protected $table='evidence';
	protected $primaryKey='idEvi';
	public $incrementing=false;
	public $timestamps=false;

    protected $fillable = [
        'idEvi',
        'idAss',
        'inscription',
        'dateLec',
        'path',
    ];
}
