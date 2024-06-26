<?php

namespace App\Http\Controllers;

use App\Models\Ajuda;
use Illuminate\Http\Request;
use Exception;
use App\Repositories\Contracts\AjudaRepositoryInterface;

class AjudaController extends Controller
{
    protected $model = Ajuda::class;

    public function __construct(AjudaRepositoryInterface $ajudaRepositoryInterface){
        $this->model =  $ajudaRepositoryInterface;
    }

    public function searchAjuda(Request $request){
      return $this->model->searchAjuda($request);
    }
    public function getAjuda($id)
    {
      
        $data = Ajuda::where('id',$id)->get();

        return $data; // Aqui você está retornando o valor associado com a chave $id
    }
    
    
    
    
    
        

    
}
