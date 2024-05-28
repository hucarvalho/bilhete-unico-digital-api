<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VotosAjudas extends Model
{
    use HasFactory;

    protected $fillable = [
        'util',
        'ajuda_id'
    ];


    public function ajuda(){
        return $this->belongsTo(Ajuda::class);
    }
}
