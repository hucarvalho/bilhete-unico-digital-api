<?php

namespace App\Http\Controllers;

use App\Models\Ajuda;
use Illuminate\Http\Request;
use Exception;
class AjudaController extends Controller
{
    protected $model;

    public function __construct(Ajuda $ajuda)
    {
        $this->model = $ajuda;
    }

    public function searchAjuda(Request $request){
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
