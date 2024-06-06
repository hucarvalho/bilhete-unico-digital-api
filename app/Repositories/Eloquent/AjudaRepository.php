<?php

namespace App\Repositories\Eloquent;

use App\Models\Ajuda;
use App\Repositories\Contracts\AjudaRepositoryInterface;
use Exception;

class AjudaRepository extends AbstractRepository implements AjudaRepositoryInterface{

    protected $model = Ajuda::class;

    public function __construct()
    {
        $this->model = app($this->model);
    }
    public function searchAjuda($request){
        try {
            $search = $request->input('tituloAjuda');
    
            
            if (empty($search)) {
                return response()->json([]); 
            }
    
            
            $ajuda = $this->model->where('tituloAjuda', 'LIKE', "%{$search}%")->get();
            return response()->json($ajuda);
        } catch(Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

  
   
}