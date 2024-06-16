<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxaEmissao extends Model
{
    use HasFactory;
    protected $fillable = [
        'pedido_bilhete_id',
        'taxa_emissao_preco_id',
        'created_at'
    ];

    public function taxaEmissaoPreco(){
        return $this->belongsTo(TaxaEmissaoPreco::class);
    }
    public function pedidoBilhete(){
        return $this->belongsTo(PedidoBilhete::class);
    }

}
