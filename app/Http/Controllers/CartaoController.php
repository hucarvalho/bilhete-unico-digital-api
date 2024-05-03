<?php

namespace App\Http\Controllers;

use App\Models\CartaoPassageiro;

use App\Repositories\Contracts\CartaoRepositoryInterface;
use Illuminate\Http\Request;
use Exception;

class CartaoController extends Controller
{
    protected $model = CartaoPassageiro::class;

    public function __construct(CartaoRepositoryInterface $cartaoPassageiroRepositoryInterface)
    {
        $this->model = $cartaoPassageiroRepositoryInterface;
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
