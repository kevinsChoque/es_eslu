<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TTecnical extends Model
{
    protected $table='tecnical';
	protected $primaryKey='idTec';
	public $incrementing=false;
	public $timestamps=false;

    protected $fillable = [
        'idTec',
        'dni',
        'name'
    ];
}
