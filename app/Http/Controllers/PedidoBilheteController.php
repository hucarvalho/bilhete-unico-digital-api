<?php

namespace App\Http\Controllers;

use App\Models\Bilhete;
use App\Models\TaxaEmissao;
use App\Repositories\Contracts\PedidoBilheteRepositoryInterface;
use App\Services\DataServices;
use Illuminate\Http\Request;

class PedidoBilheteController extends Controller
{
    protected $model;

    public function __construct(PedidoBilheteRepositoryInterface $pedido)
    {   
        $this->model = $pedido;
    }

    public function getByPassageiroId($passageiroId)
    {
        $pedido =  $this->model->getByPassageiroId($passageiroId);
        
        return response()->json($pedido);
    }
    public function store(Request $request, $idPassageiro)
    {
        if($request->tipo == "Comum" || $request->tipo == "Idoso"){
            $status = "Aprovado";
        }else{
            $status = "Aberto";
        }
        $data = [
            'tipoBilhete' => $request->tipo,
            'statusPedido' => $status,
            'passageiro_id' => $idPassageiro,
            'created_at' => now()
        ];
        return $this->model->create($data);
    }
    public function payAndStoreTaxaEmissao($pedidoBilhete)
    {
        $this->model->update($pedidoBilhete, [
            'statusPedido' => "Pago"
        ]);

        $pedido = $this->model->findById($pedidoBilhete);

        TaxaEmissao::create([
            'pedido_bilhete_id' => $pedido->id,
            'taxa_emissao_preco_id' => 1,
            'created_at' => now()
        ]);
          switch($pedido->tipoBilhete){
                case "PCD":
                    $gratuidade = 1;
                    $meiaGratuidade = 1;
                    break;
                case "Estudante Ins. Privada":
                    $gratuidade = 0;
                    $meiaGratuidade = 1;
                    break;
                case "Estudante":
                    $gratuidade = 1;
                    $meiaGratuidade = 1;
                    break;
                default:
                    $gratuidade =0;
                    $meiaGratuidade = 0;
            }
            $bilhete = Bilhete::create([
                'qrCodeBilhete' => 'Pendente',
                'numBilhete' =>  fake()->numerify('### ### ###'),
                'tipoBilhete' => $pedido->tipoBilhete,
                'gratuidadeBilhete' => $gratuidade,
                'meiaPassagensBilhete' => $meiaGratuidade,
                'statusBilhete' => 'Ativo',
                'passageiro_id' => $pedido->passageiro_id,
            ]);
            $bilhete->update([
                'qrCodeBilhete' => DataServices::qrCodeFetch($bilhete->id)
            ]);
            return true;
        

    }

}
