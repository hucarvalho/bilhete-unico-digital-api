<?php

namespace App\Http\Controllers;

use App\Models\Bilhete;
use App\Models\Passageiro;
use App\Models\Passagem;
use Illuminate\Http\Request;

class PassageiroController extends Controller
{
    protected $model = Passageiro::class;
    public function __construct()
    {
        $this->model = app($this->model);
    }
    public function getBilhetes($id)
    {
        if(!$this->model->find($id)){
            return response()->json([
                'message' => 'Você ainda não tem bilhetes'
            ]);
        }
        $bilhetes = $this->model->find($id)->bilhetes()->get();
        
        foreach($bilhetes as $bilhete){
            switch($bilhete->tipoBilhete){
                case "Estudante":
                    $bilhete['backgroundColor'] = '#4390E1';
            break;
                case "Idoso":
                    $bilhete['backgroundColor'] = '#FFDB70';
            break;
                case "Professor":
                    $bilhete['backgroundColor'] = '#98FB98';
            break;
                case "Comum":
                    $bilhete['backgroundColor'] = '#808075';
            break;
                case "Pcd":
                    $bilhete['backgroundColor'] = '#DDA0DD';
            break;
                case "Obesa":
                    $bilhete['backgroundColor'] = '#FFA500';
            break;
                case "Gestante":
                    $bilhete['backgroundColor'] = '#FFA500';
            break;
                case "Corporativo":
            default:
                    $bilhete['backgroundColor'] = '#808075';
                    break;
                    
                }
                
        }
        return $bilhetes->toJson();
    }
    public function getPassagens($id, Passagem $passagem, Bilhete $bilhete)
    {
        if(!$bilhete->find($id)){
            return response()->json([
                'message' => 'nenhum bilhete encontrado'
            ]);
        }
        $qtdPassagem = $passagem->where('bilhete_id', $id)->where('statusPassagem', 'Ativa')->get()->count();
        $consumos = $passagem
                        ->select('acaos.id as id','acaos.dataAcao as data', 'linhas.nomeLinha as linha', 'linhas.numLinha as numero')
                        ->join('consumos', 'passagems.id', 'consumos.passagem_id')
                        ->join('acaos', 'consumos.acao_id', 'acaos.id')
                        ->join('carros', 'consumos.carro_id', 'carros.id')
                        ->join('linhas', 'carros.linha_id', 'linhas.id')
                        ->where('passagems.bilhete_id', $id)
                        ->get();
        $meses = ['01' => 'JAN', '02' => 'FEV', '03' => 'MAR', '04' => 'ABR', '05' => 'MAI', '06' => 'JUN', '07' => 'JUL', '08' => 'AGO', '09' => 'SET', '10' => 'OUT','11' => 'NOV', '12' => 'DEZ'];
        foreach($consumos as $consumo){
            $tratamento = explode(" ", $consumo['data']);
            $tratamento = explode("-",$tratamento[0]);
            $consumo['data'] = $tratamento[2] . " ".$meses[$tratamento[1]];

        }
        return response()->json([
            'consumos' => $consumos,
            'qtdPassagens' => $qtdPassagem,
            'qtdConsumos' => $consumos->count()
        ]);
    }
    public function getCompras($id)
    {
        if(!$compras = $this->model->find($id)){
            return response()->json([
                'message' => 'passageiro não encontrado'
            ]);
        }
        $compras = $this->model
                        ->select('compras.qtdPassagensCompra as passagens', 'compras.valorTotalCompra as valor', 'forma_pagamentos.descFormaPagamento', 'acaos.dataAcao as dataCompra')
                        ->join('acaos', 'passageiros.id', 'acaos.passageiro_id')
                        ->join('compras', 'acaos.id', 'compras.acao_id')
                        ->join('forma_pagamentos', 'compras.forma_pagamento_id', 'forma_pagamentos.id')
                        ->where('passageiros.id', $id)
                        ->get();
        $meses = ['01' => 'JAN', '02' => 'FEV', '03' => 'MAR', '04' => 'ABR', '05' => 'MAI', '06' => 'JUN', '07' => 'JUL', '08' => 'AGO', '09' => 'SET', '10' => 'OUT','11' => 'NOV', '12' => 'DEZ'];
        $i=1;
        foreach($compras as $compra){
            $tratamento = explode(" ", $compra['dataCompra']);
            $tratamento = explode("-",$tratamento[0]);
            $compra['dataCompra'] = $tratamento[2]."/".$tratamento[1]."/".$tratamento[0];
            $compra['dataTratada'] = $tratamento[2] . " ".$meses[$tratamento[1]];
            $compra['id'] = $i;
            $i++;
        }            
            return response()->json([
                'compras' => $compras,
                'qtdCompras' => $compras->count()
            ]);
        
    }
    public function getComprasByBilhete($id,$bilheteId, Bilhete $bilheteModel)
    {
        if(!$bilheteModel->find($bilheteId)){
            return response()->json([
                'message' => 'bilhete não encontrado'
            ]);
        }
        if(!$this->model->find($id)){
            return response()->json([
                'message' => 'passageiro não encontrado'
            ]);
        }
        $compras = $this->model
                        ->select('compras.qtdPassagensCompra as passagens', 'compras.valorTotalCompra as valor', 'forma_pagamentos.descFormaPagamento', 'acaos.dataAcao as dataCompra')
                        ->join('acaos', 'passageiros.id', 'acaos.passageiro_id')
                        ->join('compras', 'acaos.id', 'compras.acao_id')
                        ->join('forma_pagamentos', 'compras.forma_pagamento_id', 'forma_pagamentos.id')
                        ->where('passageiros.id', $id)
                        ->where('compras.bilhete_id', $bilheteId)
                        ->get();
        $meses = ['01' => 'JAN', '02' => 'FEV', '03' => 'MAR', '04' => 'ABR', '05' => 'MAI', '06' => 'JUN', '07' => 'JUL', '08' => 'AGO', '09' => 'SET', '10' => 'OUT','11' => 'NOV', '12' => 'DEZ'];
        $i = 1;
        foreach($compras as $compra){
            $tratamento = explode(" ", $compra['dataCompra']);
            $tratamento = explode("-",$tratamento[0]);
            $compra['dataCompra'] = $tratamento[2]."/".$tratamento[1]."/".$tratamento[0];
            $compra['dataTratada'] = $tratamento[2] . " ".$meses[$tratamento[1]];
            $compra['id'] = $i;
            $i++;
        }            
            return response()->json([
                'compras' => $compras,
                'qtdCompras' => $compras->count()
            ]);
        
    }
    public function getCartoes($id)
    {
        return $this->model->find($id)->cartaoPassageiro()->get()->toJson();
    }
}
