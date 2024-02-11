<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preco extends Model
{
    use HasFactory;
    protected $fillable = [
        'passagemPreco',
        'meiaPassagemPreco',
    ];
    protected static function boot()
    {
        parent::boot();
        
        static::updating(function ($preco) {
            $preco->meiaPassagemPreco = $preco->passagemPreco / 2;
        });
    }
}
