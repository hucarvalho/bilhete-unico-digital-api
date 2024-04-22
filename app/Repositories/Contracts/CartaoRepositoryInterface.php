<?php 

namespace App\Repositories\Contracts;

interface CartaoRepositoryInterface{

    public function storeCartao($request, $id);
    public function getCartao($id);
    public function destroyCartao($id);

}