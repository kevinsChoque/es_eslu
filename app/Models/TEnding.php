<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TEnding extends Model
{
    protected $table='ending';
	protected $primaryKey='idEnd';
	public $incrementing=false;
	public $timestamps=false;

    protected $fillable = [
        'idEnd',
        'date',
        'hour',
        'state',
        'mes',
    ];
}
