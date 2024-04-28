<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produto extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'produto';
    protected $primaryKey = 'cod_produto';
    public $timestamps = false;

    protected $fillable = [
        'cod_produto',
        'nome',
        'quantidade',
        'preco',
        'descricao',
        'sede',
    ];
}
