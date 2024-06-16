<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxaEmissaoPreco extends Model
{
    use HasFactory;
    protected $fillable = [
        'taxa'
    ];

    public function taxaEmissao()
    {
        $this->hasOne(TaxaEmissao::class);
    }
}
