<?php

namespace App\Http\Controllers;

use App\Models\Passageiro;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    protected $model;
    public function __construct(Passageiro $passageiro)
    {
        $this->model = $passageiro;
    }
    public function all()
    {
        $passageiros = $this->model->get()->toJson(JSON_PRETTY_PRINT);
        return response($passageiros, 200);
    }
    public function getById($id)
    {
        $passageiro = $this->model->find($id);
        if($passageiro)
        {
            $passageiro = $this->model->where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($passageiro, 200);
        }else
        {
            return response()->json([
                'mensagem' => 'Nenhum passageiro encontrado.'
            ]);
        }
    }
}
