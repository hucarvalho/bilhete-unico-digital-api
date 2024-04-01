<?php

namespace App\Http\Controllers;

use App\Models\Bilhete;
use App\Models\Passagem;
use App\Repositories\Contracts\PassagemRepositoryInterface;
use Illuminate\Http\Request;

class PassagemController extends Controller
{
    protected $model = Passagem::class;
    public function __construct(PassagemRepositoryInterface $passagemRepositoryInterface){
        $this->model =$passagemRepositoryInterface;
    }
    public function getPassagens($id){
        return $this->model->getPassagens($id);
    }
    public function getPassagemEmUso($idBilhete){
        return $this->model->getPassagemEmUso($idBilhete);
    }
   
}
