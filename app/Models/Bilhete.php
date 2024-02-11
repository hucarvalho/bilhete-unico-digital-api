<?php

namespace App\Models;

use Database\Factories\BilheteFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bilhete extends Model
{
    use HasFactory;

    protected $fillable = [
        'qrCodeBilhete',
        'numBilhete',
        'tipoBilhete',
        'gratuidadeBilhete',
        'meiaPassagensBilhete',
        'statusBilhete',
        'passageiro_id'
    ];

    protected $casts = [
        'gratuidadeBilhete' => 'boolean',
        'meiaPassagensBilhete' => 'boolean',
    ];

    public function passageiros(){
       return  $this->belongsTo(Passageiro::class);
    }

    public function passagem(){
       return $this->hasMany(Passagem::class);
    }
    protected static function newFactory()
    {
        return BilheteFactory::new();
    }
}
