<?php  

namespace App\Repositories\Contracts;


interface PedidoBilheteRepositoryInterface
{
    public function search(String | null $search = null, $status);
    public function get();
    public function getAllpedidos();
    public function findWithPassageiro($id);
    public function update($id, $data);
    public function getByPassageiroId($passageiroId);
}