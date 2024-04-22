<?php 

namespace App\Repositories\Contracts;

interface PassageiroRepositoryInterface{

    public function getCompras($id);
    public function getComprasByBilhete($id,$bilheteId,$bilheteModel); 
    public function getCartoes($id);
    public function getPreco($preco);
    public function checkLastConsumo($idPassagem);
    public function getPassagemEmUso($idBilhete);
    public function getPassagemAtiva($idBilhete);
    public function storeCompra($dados, $idAcao, $dataAcao);
    public function storeConsumo($request, $acaoId, $data);
    public function storeAcao($request,$acao,$id);
    public function inativarPassagem($idPassagem);
    public function callConsumo($idCatraca, $idBilhete);
    public function countCompras($idBilhete);
}