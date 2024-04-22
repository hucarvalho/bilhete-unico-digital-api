<?php

namespace App\Http\Controllers;

use App\Models\CartaoPassageiro;
use Illuminate\Http\Request;
use Exception;

class CartaoController extends Controller
{
    protected $model;

    public function __construct(CartaoPassageiro $cartaoPassageiro)
    {
        $this->model = $cartaoPassageiro;
    }
    public function storeCartao(Request $request, $id)
    {
        return $this->model->storeCartao($request,$id);
    }
    public function getCartao($id){
        
        return $this->model->getCartao($id);
    }

    public function destroyCartao($id){
        return $this->model->destroyCartao($id);
    }
}
