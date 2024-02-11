<?php

namespace App\Models;

use Database\Factories\CatracaFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Catraca extends Model
{
    use HasFactory;
    protected $fillable = [
        'statusCatraca',
    ];

    public function carro(){
        return $this->hasOne(Carro::class);
    }

    protected static function newFactory()
{
    return CatracaFactory::new();
}
}
