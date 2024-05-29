<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VotosAjudas extends Model
{
    use HasFactory;

    protected $fillable = [
        'util',
        'ajuda_id',
        'passageiro_id'
    ];

    public function passageiros(){
        return  $this->belongsTo(Passageiro::class);
     }

    public function ajuda(){
        return $this->belongsTo(Ajuda::class);
    }
}
