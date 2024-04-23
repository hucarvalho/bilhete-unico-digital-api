<?php

namespace App\Http\Controllers;

use App\Models\Acao;
use App\Models\Bilhete;
use App\Models\Compra;
use App\Models\Consumo;
use App\Models\Passageiro;
use App\Models\Passagem;
use App\Models\Preco;
use App\Repositories\Contracts\PassageiroRepositoryInterface;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class PassageiroController extends Controller
{
  
    protected $model = Passageiro::class;

    public function __construct(PassageiroRepositoryInterface $passageiroRepositoryInterface){
        $this->model =  $passageiroRepositoryInterface;
    }
    public function getCompras($id)
    {   
        return $this->model->getCompras($id);
    }
    public function getComprasByBilhete($id,$bilheteId,Bilhete $bilheteModel)
    {
        return $this->model->getComprasByBilhete($id,$bilheteId,$bilheteModel);
    }
    public function getCartoes($id)
    {
        return $this->model->getCartoes($id);
    }
    public function getPreco(Preco $preco)
    {
        return $this->model->getPreco($preco);
    }
    public function storeAcao(Request $request,Acao $acao,$id){
        return $this->model->storeAcao($request,$acao,$id);
    }
    public function storeCompra($dados, $idAcao, $dataAcao){
        return $this->model->storeCompra($dados, $idAcao, $dataAcao);
    }

    public function checkLastConsumo($idPassagem)
    {
        return $this->model->checkLastConsumo($idPassagem);
    }

    public function getPassagemEmUso($idBilhete){
        return $this->model->getPassagemEmUso($idBilhete);
    }
    public function getPassagemAtiva($idBilhete){
        return $this->model->getPassagemAtiva($idBilhete);
    }

    public function storeConsumo($request, $acaoId, $data){
        return $this->model->storeConsumo($request, $acaoId, $data);
        }

    public function inativarPassagem($idPassagem)
    {
        return $this->model->inativarPassagem($idPassagem);
    }

    public function callConsumo($idCatraca, $idBilhete)
    {
        return $this->model->callConsumo($idCatraca, $idBilhete);
    }

    public function countCompras($idBilhete){
        return $this->model->countCompras($idBilhete);
    }
        
    public function insertFoto($idPassageiro, Request $request){
        return response()->json([
            'respsta' => $request->file->name
        ]);
    }
        
        
}

