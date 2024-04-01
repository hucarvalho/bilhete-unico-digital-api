<?php 

namespace App\Repositories\Contracts;

interface PassagemRepositoryInterface{
    public function getPassagens($idBilhete);
    public function getPassagemEmUso($idBilhete);
}