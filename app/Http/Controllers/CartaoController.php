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
        try{
            $data = $request->all();

            $data['passageiro_id'] = $id;
            
            $cartao = CartaoPassageiro::create($data);
           
                    return response()->json([
            
                        'message' => $data
                    ]);
            
                }catch(Exception $e){
                    return response()->json([
                        'message' => $e->getMessage()
                    ]);
                }
    }
    public function getCartao($id){
        
        return response()->json(
            $this->model->where('passageiro_id',$id)->get());

    }

    public function destroyCartao($id){
        $this->model->destroy($id);

        return response ()-> json("Usuario deletado com sucesso");

    }
}
