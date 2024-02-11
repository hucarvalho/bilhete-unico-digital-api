<?php

namespace App\Models;

use Database\Factories\CartaoPassageiroFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartaoPassageiro extends Model
{
    use HasFactory;
    protected $fillable = [
        'numeroCartao',
        'bandeiraCartao',
        'bancoCartao',
        'cvcCartao',
        'contaCartao',
        'agenciaCartao',
        'validadeCartao',
    ];

    public function passageiro(){
        return $this->belongsTo(Passageiro::class);
    }
    protected static function newFactory()
    {
        return CartaoPassageiroFactory::new();
    }
}
