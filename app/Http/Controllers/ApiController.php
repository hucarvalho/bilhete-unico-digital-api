<?php

namespace App\Http\Controllers;

use App\Models\Passageiro;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    protected $model;
    public function __construct(Passageiro $passageiro)
    {
        $this->model = $passageiro;
    }
    
   
}
