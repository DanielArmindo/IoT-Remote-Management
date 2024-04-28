<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    use HasFactory;

    protected $table = 'vendas';
    protected $primaryKey = 'cod_venda';
    public $timestamps = false;

    protected $fillable = [
        'cod_utilizador',
        'cod_produto',
        'quantidade',
        'preco',
        'estado'
    ];

    public function produtoRef()
    {
        return $this->belongsTo(Produto::class, 'cod_produto');
    }
}
