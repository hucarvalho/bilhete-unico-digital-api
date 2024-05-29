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
}
