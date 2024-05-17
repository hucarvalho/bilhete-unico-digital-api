<?php

namespace App\Http\Controllers;

use App\Models\Passageiro;

class ApiController extends Controller
{
    protected $model;
    public function __construct(Passageiro $passageiro)
    {
        $this->model = $passageiro;
    }
    
    public function testConnection(){
        return true;
    }
   
}
