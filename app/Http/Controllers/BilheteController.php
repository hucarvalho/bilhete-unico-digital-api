<?php

namespace App\Http\Controllers;

use App\Models\Bilhete;
use App\Repositories\Contracts\BilheteRepositoryInterface;

class BilheteController extends Controller
{
    
    protected $model = Bilhete::class;

    public function __construct(BilheteRepositoryInterface $bilheteRepositoryInterface){
        $this->model =  $bilheteRepositoryInterface;
    }

    public function getBilhetes($idPassageiro)
    {
       return $this->model->getBilhetes($idPassageiro);
    }
}
