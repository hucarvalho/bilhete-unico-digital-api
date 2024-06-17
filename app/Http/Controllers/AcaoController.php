<?php

namespace App\Http\Controllers;
use App\Models\Acao;
use Illuminate\Http\Request;

class AcaoController extends Controller
{
    protected $model;

public function __construct(Acao $acao)
{
    $this->model = $acao;
}
   public function getAcoes($idP){
    // $this->model->all()
    $acaoPassageiro = $this->model->where('id',$idP)->get();
    return response()->json($acaoPassageiro);
   }
}
