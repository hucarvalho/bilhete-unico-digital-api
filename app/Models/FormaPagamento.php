<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormaPagamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'descFormaPagamento',
    ];

    public function compras(){
        return $this->hasMany(Compra::class);
    }
}
