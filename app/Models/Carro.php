<?php

namespace App\Models;

use Database\Factories\CarroFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carro extends Model
{
    use HasFactory;
    protected $fillable = [
        'numCarro',
        'statusCarro',
    ];

    public function catraca(){
        return $this->belongsTo(Catraca::class);
    }

    public function linha(){
        return $this->belongsTo(Linha::class);
    }
    protected static function newFactory()
    {
        return CarroFactory::new();
    }
}
