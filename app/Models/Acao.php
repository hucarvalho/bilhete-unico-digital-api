<?php

namespace App\Models;

use Database\Factories\AcaoFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acao extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipoAcao',
        'dataAcao'
    ];

    public function configure(){
        return $this->afterMaking(function(Acao $acao){
            
            
        })->afterCreating(function(Acao $acao){
            $acao->compra(Compra::factory()->count(1)->for($acao)->create());
        });
    }

    public function passageiro(){
        return $this->belongsTo(Passageiro::class);
    }

    public function suportes(){
        return $this->hasOne(Suporte::class);
    }

    public function consumos(){
        return $this->hasOne(Consumo::class);
    }

    public function compra(){
        return $this->hasOne(Compra::class);
    }

    protected static function newFactory()
    {
        return AcaoFactory::new();
    }
}
