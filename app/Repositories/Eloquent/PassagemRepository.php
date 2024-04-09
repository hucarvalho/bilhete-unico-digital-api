<?php

namespace App\Repositories\Eloquent;

use App\Models\Bilhete;
use App\Models\Passagem;
use App\Repositories\Contracts\PassagemRepositoryInterface;

class PassagemRepository extends AbstractRepository implements PassagemRepositoryInterface{

    protected $model = Passagem::class;

    public function __construct()
    {
        $this->model = app($this->model);
    }
    public function getPassagens($idBilhete)
    {
        //instancia do modelo e procurar o bilhete pelo id
        $bilhete = new Bilhete();

        if(!$bilhete->find($idBilhete)){
            return response()->json([
                'message' => false
            ]);
        }
        //quantidade de passagens ativas
        $qtdPassagem = $this->model->where('bilhete_id', $idBilhete)->where('statusPassagem', 'Ativa')->get()->count();
        //ultimos 7 consumos do passageiro
        $consumos = $this->model
                        ->select('acaos.id as id','acaos.dataAcao as data', 'linhas.nomeLinha as linha', 'linhas.numLinha as numero')
                        ->join('consumos', 'passagems.id', 'consumos.passagem_id')
                        ->join('acaos', 'consumos.acao_id', 'acaos.id')
                        ->join('carros', 'consumos.carro_id', 'carros.id')
                        ->join('linhas', 'carros.linha_id', 'linhas.id')
                        ->where('passagems.bilhete_id', $idBilhete)
                        ->orderBy('consumos.id', 'desc')
                        ->take(7)
                        ->get();
        //quantidade total dos consumos                        
        $qtdConsumos = $this->model
                        ->select('acaos.id as id','acaos.dataAcao as data', 'linhas.nomeLinha as linha', 'linhas.numLinha as numero')
                        ->join('consumos', 'passagems.id', 'consumos.passagem_id')
                        ->join('acaos', 'consumos.acao_id', 'acaos.id')
                        ->join('carros', 'consumos.carro_id', 'carros.id')
                        ->join('linhas', 'carros.linha_id', 'linhas.id')
                        ->where('passagems.bilhete_id', $idBilhete)
                        ->get()
                        ->count();
        //tratamento de dados
        $meses = ['01' => 'JAN', '02' => 'FEV', '03' => 'MAR', '04' => 'ABR', '05' => 'MAI', '06' => 'JUN', '07' => 'JUL', '08' => 'AGO', '09' => 'SET', '10' => 'OUT','11' => 'NOV', '12' => 'DEZ'];
        foreach($consumos as $consumo){
            $tratamento = explode(" ", $consumo['data']);
            $tratamento = explode("-",$tratamento[0]);
            $consumo['data'] = $tratamento[2] . " ".$meses[$tratamento[1]];

        }
        //retornando os dados
        return response()->json([
            'consumos' => $consumos,
            'qtdPassagens' => $qtdPassagem,
            'qtdConsumos' => $qtdConsumos
        ]);
    }

    public function getPassagemEmUso($idBilhete){
        return $this->model
            ->where('statusPassagem', 'Em uso')
            ->where('bilhete_id', $idBilhete)
            ->first();
    }
    public function getPassagemAtiva($idBilhete){
        return $this->model 
            ->where('statusPassagem', 'Ativa')
            ->where('bilhete_id', $idBilhete)
            ->first();
    }
    public function inativarPassagem($idPassagem)
    {
        $this->model->find($idPassagem)->update([
            'statusPassagem' => 'Inativa'
        ]);
        return response()->json([
            'message' => true
        ]);
    }
}