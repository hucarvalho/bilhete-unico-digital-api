<?php

namespace App\Http\Controllers;

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
}
