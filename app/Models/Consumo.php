<?php

namespace App\Models;

use Database\Factories\ConsumoFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consumo extends Model
{
    use HasFactory;

    

    public function carro(){ 
        return $this->belongsTo(Carro::class);
    }
    public function passagems(){
        return $this->belongsTo(Passagem::class);
    }

    public function acaos(){
        return $this->belongsTo(Acao::class);
    }
    protected static function newFactory()
    {
        return ConsumoFactory::new();
    }
}
