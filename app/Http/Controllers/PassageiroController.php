<?php

namespace App\Http\Controllers;

use App\Models\Acao;
use App\Models\Bilhete;
use App\Models\Compra;
use App\Models\Consumo;
use App\Models\Passageiro;
use App\Models\Passagem;
use App\Models\Preco;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

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
                'message' => 'semBilhetes'
            ]);
        }
        $bilhetes = $this->model->find($id)->bilhetes()->get();

        if($bilhetes->count() >0){
        
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
    }else{
        return response()->json([
            'message' => 'semBilhetes'
        ]);
    }
    }
    public function getPassagens($id, Passagem $passagem, Bilhete $bilhete)
    {
        if(!$bilhete->find($id)){
            return response()->json([
                'message' => false
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
                        ->select('compras.qtdPassagensCompra as passagens', 'compras.valorTotalCompra as valor', 'forma_pagamentos.id as forma', 'acaos.dataAcao as dataCompra')
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
    public function getPreco(Preco $preco)
    {
        return $preco->find(1)->passagemPreco;
    }
    public function storeAcao(Request $request,Acao $acao,$id){
        $data = $request->all();
        $data['dataAcao'] = now(); 
        $data['passageiro_id'] = $id;
        $tipo = $data['tipoAcao'];
        $acao = $acao->create($data);
        switch($tipo){
            case 'Compra':
               return $this->storeCompra($request->all(), $acao->id, $acao->dataAcao);
               break;
            case 'Consumo':
               return $this->storeConsumo($request->all(), $acao->id, $acao->dataAcao);
                break;
        
        }
    }
    public function storeCompra($dados, $idAcao, $dataAcao){
        $data = $dados;
        $data['acao_id'] = $idAcao;

        $compra = Compra::create($data);

        try{
        for ($i = 1; $i<=$compra->qtdPassagensCompra; $i++) {
            Passagem::create([
                'statusPassagem' => 'Ativa',
                'tempoRestantePassagem' => '00:00:00',
                'bilhete_id' => $data['bilhete_id']
            ]);
        }
        $dataAcao = explode(" ", $dataAcao);
        $dataAcao = $dataAcao[0];
        $dataAcao = explode("-", $dataAcao);
        $dataAcao = $dataAcao[2]."/".$dataAcao[1]."/".$dataAcao[0];
        $data = [
            'passagens' => $compra->qtdPassagensCompra,
            'valor' => $compra->valorTotalCompra,
            'forma' => $compra->forma_pagamento_id,
            'dataCompra' => $dataAcao,
        ];

        return response()->json([

            'message' => $data
        ]);
    }catch(Exception $e){
        return response()->json([
            'message' => $e->getMessage()
        ]);
    }



    }

    public function checkLastConsumo($idPassagem)
    {
        return Consumo::where('passagem_id', $idPassagem)
            ->orderBy('updated_at', 'desc')
            ->first();
    }

    public function getPassagemEmUso($idBilhete){
        return Passagem::
            where('statusPassagem', 'Em uso')
            ->where('bilhete_id', $idBilhete)
            ->first();
    }
    public function getPassagemAtiva($idBilhete){
        return Passagem::
            where('statusPassagem', 'Ativa')
            ->where('bilhete_id', $idBilhete)
            ->first();
    }

    public function storeConsumo($request, $acaoId, $data){

        
        

       //sorteando o numero do carro
        $request['carro_id'] = fake()->numberBetween(1, 100);

        //verificar se há passagem em uso
        $passagem = $this->getPassagemEmUso($request['bilhete_id']);


        //se nao há verificar se há ativa
        if($passagem == null){
            
            $passagem = $this->getPassagemAtiva($request['bilhete_id']);
            
        }  
        else{
            //verificar se a passagem foi usada no mesmo carro da ultima vez
            $ultimoConsumo = $this->checkLastConsumo($passagem->id);
            if($ultimoConsumo->carro_id == $request['carro_id']){
                //se foi retornar mensagem de erro
                return response()->json([
                    'message' => 'Erro, não é possivel usar o bilhete na mesma catraca'
                ]);
            }


        } 
            //se não ha retornar mensagem
            if($passagem == null){
                return response()->json([
                    'message' => 'Você não possui passagens, por favor recarregue seu bilhete'
                ]);
            }

        //montando o request
        $request['acao_id'] = $acaoId;
        $request['passagem_id'] = $passagem->id;
        
        
        
        //Atualizando a passagem utilizada
        if($passagem->statusPassagem != 'Em uso'){
         $passagem->update([
            'updated_at' => $data,
            'statusPassagem' => 'Em uso'
        ]);
    }
        Consumo::create($request);
        

        return response()->json([
            'message' => 'Sucesso ao consumir passagem, boa viagem'
        ]);
        }

    public function inativarPassagem($idPassagem)
    {
        Passagem::find($idPassagem)->update([
            'statusPassagem' => 'Inativa'
        ]);
        return response()->json([
            'message' => true
        ]);
    }

    public function callConsumo($idCatraca, $idBilhete)
    {
        $idPassageiro = $this->model->
                            select('passageiros.id')
                            ->join('bilhetes', 'passageiros.id', 'bilhetes.passageiro_id')
                            ->where('bilhetes.id', $idBilhete)
                            ->first();
        
        $acao= new Acao();
         $acao = $acao->create([
            'dataAcao' => now(),
            'tipoAcao' =>'Consumo',
            'passageiro_id' => $idPassageiro->id
        ]);

        //verificar se há passagem em uso
        $passagem = $this->getPassagemEmUso($idBilhete);


        //se nao há verificar se há ativa
        if($passagem == null){
            
            $passagem = $this->getPassagemAtiva($idBilhete);
            
        }  
        else{
            //verificar se a passagem foi usada no mesmo carro da ultima vez
            $ultimoConsumo = $this->checkLastConsumo($passagem->id);
            if($ultimoConsumo->carro_id == $idCatraca){
                //se foi retornar mensagem de erro
                return response()->json(0);
            }


        } 
            //se não ha retornar mensagem
            if($passagem == null){
                return response()->json(0);
            }

        //montando o request
        $data['acao_id'] = $acao->id;
        $data['passagem_id'] = $passagem->id;
        $data['carro_id'] = $idCatraca;
        
        
        //Atualizando a passagem utilizada
        if($passagem->statusPassagem != 'Em uso'){
         $passagem->update([
            'updated_at' => $acao->dataAcao,
            'statusPassagem' => 'Em uso'
        ]);
    }
        Consumo::create($data);
        

        return response()->json(1);

    }

    public function countCompras($idBilhete){
        $qtdCompras = $this->model
        ->select('compras.qtdPassagensCompra as passagens', 'compras.valorTotalCompra as valor', 'forma_pagamentos.id as forma', 'acaos.dataAcao as dataCompra')
        ->join('acaos', 'passageiros.id', 'acaos.passageiro_id')
        ->join('compras', 'acaos.id', 'compras.acao_id')
        ->join('forma_pagamentos', 'compras.forma_pagamento_id', 'forma_pagamentos.id')
        ->where('compras.bilhete_id', $idBilhete)
        ->get()
        ->count();
        return $qtdCompras;
    }
        

        
        
}

