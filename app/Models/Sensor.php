<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    use HasFactory;

    protected $table = 'sensores';
    protected $primaryKey = 'cod_sensor';
    public $timestamps = false;

    protected $fillable = [
        'nome',
        'valor',
        'data_hora',
        'log',
    ];

}
