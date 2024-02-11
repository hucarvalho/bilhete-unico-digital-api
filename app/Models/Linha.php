<?php

namespace App\Models;

use Database\Factories\LinhaFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Linha extends Model
{
    use HasFactory;
    protected $fillable = [
        'numLinha',
        'nomeLinha',
        'statusLinha'
    ];

    public function carros(){
        return $this->hasMany(Carro::class);
    }
    protected static function newFactory()
    {
        return LinhaFactory::new();
    }
    public function getLinhas(String | null $search = null)
    {
        $linha = new Linha();
        // $linha = $this->where(function($query) use ($search){
        //     if($search)
        //     {
        //     $query->where('nomeLinha','LIKE',"%{$search}%");
        //     $query->orWhere('numLinha','LIKE',"%{$search}%");
        //     }
        // })->get();  
        $linhas = $linha
        ->select('linhas.id','numLinha', 'nomeLinha')
        ->selectRaw('COUNT(carros.id) as qtdCarros')
        ->join('carros', 'linhas.id', '=', 'carros.linha_id')
        ->groupBy('id', 'numLinha', 'nomeLinha')
        ->where('nomeLinha','LIKE',"%{$search}%")
        ->orWhere('numLinha','LIKE',"%{$search}%")
        ->get();   


        return $linhas;
        
    }
}
