<?php

namespace App\Http\Controllers;

use App\Models\VotosAjudas;
use Illuminate\Http\Request;

class VotosAjudasController extends Controller
{
    protected $model = VotosAjudas::class;

    public function store(Request $request, $id){
        $data = $request->all();
        $data['ajuda_id'] =$id;

        VotosAjudas::create($data);

        return response()->json([
            
            'message' => $data
        ]);
    }
}
