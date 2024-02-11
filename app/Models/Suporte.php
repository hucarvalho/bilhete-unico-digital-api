<?php

namespace App\Models;

use Database\Factories\SuporteFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suporte extends Model
{
    use HasFactory;

    protected $fillable = [
        'categoriaSuporte',
        'descSuporte',
        'statusSuporte'
    ];

    public function acaos(){
        return $this->belongsTo(Acao::class);
    }
    protected static function newFactory()
    {
        return SuporteFactory::new();
    }
    public function getSuportes(String | null $search = null)
    {
        
        $suportes = $this
        ->select('suportes.id as idSuporte','emailPassageiro as email', 'descSuporte as desc', 'dataAcao as data', 'categoriaSuporte as tema', 'statusSuporte as status' )
                    ->join('acaos', 'suportes.acao_id', 'acaos.id')
                    ->join('passageiros', 'acaos.passageiro_id', 'passageiros.id')
                    ->where('emailPassageiro','LIKE',"%{$search}%")
                    ->orWhere('descSuporte','LIKE',"%{$search}%")
                    ->orWhere('dataAcao','LIKE',"%{$search}%")
                    ->get();

        
        return $suportes;
        
    }
}
