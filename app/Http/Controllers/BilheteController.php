<?php

namespace App\Http\Controllers;

use App\Models\Bilhete;
use App\Models\Passageiro;
use Illuminate\Http\Request;

class BilheteController extends Controller
{
    protected $model = Bilhete::class;
    
    public function __construct()
    {
        $this->model = app($this->model);
    }

    public function getBilhetes($idPassageiro)
    {
        $passageiro = new Passageiro();
        if(!$passageiro->find($idPassageiro)){
            return response()->json([
                'message' => 'semBilhetes'
            ]);
        }
        $bilhetes = $passageiro->find($idPassageiro)->bilhetes()->get();

        if($bilhetes->count() >0){
        
        foreach($bilhetes as $bilhete){
            switch($bilhete->tipoBilhete){
                case "Estudante":
                    $bilhete['backgroundColor'] = '#4390E1';
            break;
                case "Idoso":
                    $bilhete['backgroundColor'] = '#FFDB70';
            break;
                case "Professor":
                    $bilhete['backgroundColor'] = '#98FB98';
            break;
                case "Comum":
                    $bilhete['backgroundColor'] = '#808075';
            break;
                case "Pcd":
                    $bilhete['backgroundColor'] = '#DDA0DD';
            break;
                case "Obesa":
                    $bilhete['backgroundColor'] = '#FFA500';
            break;
                case "Gestante":
                    $bilhete['backgroundColor'] = '#FFA500';
            break;
                case "Corporativo":
            default:
                    $bilhete['backgroundColor'] = '#808075';
                    break;
                    
                }
                
        }
        return $bilhetes->toJson();
    }else{
        return response()->json([
            'message' => 'semBilhetes'
        ]);
    }
    }
}
