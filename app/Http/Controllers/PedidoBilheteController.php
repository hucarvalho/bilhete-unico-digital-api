<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\PedidoBilheteRepositoryInterface;
use Illuminate\Http\Request;

class PedidoBilheteController extends Controller
{
    protected $model;

    public function __construct(PedidoBilheteRepositoryInterface $pedido)
    {   
        $this->model = $pedido;
    }

    public function getByPassageiroId($passageiroId)
    {
        $pedido =  $this->model->getByPassageiroId($passageiroId);
        
        return response()->json($pedido);
    }
    public function store(Request $request, $idPassageiro)
    {
        $data = [
            'tipoBilhete' => $request->tipo,
            'statusPedido' => "Aberto",
            'passageiro_id' => $idPassageiro,
            'created_at' => now()
        ];
        return $this->model->create($data);
    }

}
