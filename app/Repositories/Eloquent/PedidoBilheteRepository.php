<?php  

namespace  App\Repositories\Eloquent;

use App\Models\PedidoBilhete;
use App\Repositories\Contracts\PedidoBilheteRepositoryInterface;

class PedidoBilheteRepository extends AbstractRepository implements PedidoBilheteRepositoryInterface
{
    protected $model = PedidoBilhete::class;

    public function __construct()
    {
        $this->model = app($this->model);
    }
    public function get()
    {
        return $this->model
                    ->where('statusPedido', 'Aberto')
                    ->count();
    }
    public function search(String | null $search = null, $status) {
        return $this->model
        ->select('pedido_bilhetes.id','pedido_bilhetes.tipoBilhete', 'pedido_bilhetes.statusPedido', 'pedido_bilhetes.passageiro_id', 'passageiros.nomePassageiro as passageiro_nome')
                    ->join('passageiros', 'pedido_bilhetes.passageiro_id', '=', 'passageiros.id')
                    ->where(function($query) use ($search, $status){
                        if($search == null){
                            $query->where('statusPedido', $status);
                        }else{
                            $query->where('passageiros.nomePassageiro','LIKE',"%{$search}%");
                            $query->orWhere('pedido_bilhetes.tipoBilhete','LIKE',"%{$search}%");
                        }
                    })
                    ->orderByRaw('LENGTH(pedido_bilhetes.tipoBilhete) DESC')
                    ->paginate(15);
    }
    public function getAllpedidos(){
        return $this->model
            ->select('pedido_bilhetes.id','pedido_bilhetes.tipoBilhete', 'pedido_bilhetes.statusPedido', 'pedido_bilhetes.passageiro_id', 'passageiros.nomePassageiro as passageiro_nome')
            ->join('passageiros', 'pedido_bilhetes.passageiro_id', '=', 'passageiros.id')
            
            ->paginate(15);
    }
    public function findWithPassageiro($id)
    {
        return $this->model
            ->select('pedido_bilhetes.id as idPedido','pedido_bilhetes.passageiro_id as idPassageiro' ,'pedido_bilhetes.tipoBilhete as tipo', 'pedido_bilhetes.statusPedido as status', 'pedido_bilhetes.created_at as data', 'passageiros.nomePassageiro as nome', 'passageiros.emailPassageiro as email', 'passageiros.cpfPassageiro as cpf', 'passageiros.dataNascPassageiro as nasc', 'passageiros.fotoPassageiro as foto')
            ->join('passageiros', 'pedido_bilhetes.passageiro_id', '=', 'passageiros.id')
            ->where('pedido_bilhetes.id', $id)
            ->get();
    }   
    public function getByPassageiroId($passageiroId)
    {
        return $this->model
                ->select('id','statusPedido as status', 'tipoBilhete as tipo', 'created_at as data')
                ->where('passageiro_id', $passageiroId)
                ->get();
    }
    
    
}
