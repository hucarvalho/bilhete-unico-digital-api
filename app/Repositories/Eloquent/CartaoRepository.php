<?php

namespace App\Repositories\Eloquent;

use App\Models\CartaoPassageiro;
use App\Repositories\Contracts\CartaoRepositoryInterface;
use Exception;

class CartaoRepository extends AbstractRepository implements CartaoRepositoryInterface{

    protected $model = CartaoPassageiro::class;

    public function __construct()
    {
        $this->model = app($this->model);
    }
    public function storeCartao($request, $id)
    {
        try{
            $data = $request->all();

            $data['passageiro_id'] = $id;
            
            CartaoPassageiro::create($data);
           
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