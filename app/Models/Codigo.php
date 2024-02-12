<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Codigo extends Model
{
    use HasFactory;
    protected $fillable = [
        'codigo',
        'tipoCodigo',
        'passageiro_id',
        'wasUsed'
    ];

    public function passageiro(){
        return $this->belongsTo(Passageiro::class);
    }
}
