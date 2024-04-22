<?php 

namespace App\Repositories\Contracts;

interface BilheteRepositoryInterface{

    public function getBilhetes($idPassageiro);
    
}