<?php

namespace App\Http\Controllers;

use App\Models\Ajuda;
use App\Models\VotosAjudas;
use Illuminate\Http\Request;

class VotosAjudasController extends Controller
{
    protected $model = VotosAjudas::class;

    public function store(Request $request, $id){
        $data = $request->all();
        $data['ajuda_id'] = $id;
        $votoExistente = VotosAjudas::where('ajuda_id', $id)
                                    ->where('passageiro_id', $data['passageiro_id'])
                                    ->first();

        if ($votoExistente) {
            $votoExistente->update($data);
            return response()->json([
                'message' => 'Voto atualizado com sucesso',
            ]);
        } else {
            
            VotosAjudas::create($data);
            return response()->json([
                'message' => 'Voto registrado com sucesso',
                
            ]);
        }
    }

    public function getVoto($idPassageiro, $ajuda_id)
    {
        // Faça a consulta usando o modelo VotosAjudas e o método where para adicionar as condições
        return response()->json(
        VotosAjudas::where('passageiro_id', $idPassageiro)
                           ->where('ajuda_id', $ajuda_id)
                           ->pluck('util')
                           ->first()

        );
    }
    public function getPorcentagemVoto()
    {
        // Obtém todas as ajudas com seus IDs e contagens de votos úteis
        $ajudas = Ajuda::all()->map(function ($ajuda) {
            $count = VotosAjudas::where('ajuda_id', $ajuda->id)
                        ->where('util', 1)
                        ->count();
            return [
                'id' => $ajuda->id,
                'titulo' => $ajuda->tituloAjuda,
                'votos_uteis' => $count
            ];
        });
    
        // Ordena as ajudas em ordem decrescente com base nos votos úteis
        $ajudas = $ajudas->sortByDesc('votos_uteis')->values()->take(3); // Adicionando ->values()
    
        // Retorna os resultados como JSON
        return response()->json($ajudas);
    }
    

    
    
}
