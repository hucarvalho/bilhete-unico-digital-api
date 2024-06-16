<?php

use App\Models\TaxaEmissao;
use App\Repositories\Contracts\TaxaEmissaoRepositoryInterface;
use App\Repositories\Eloquent\AbstractRepository;

class TaxaEmissaoRepository extends AbstractRepository implements TaxaEmissaoRepositoryInterface{

    protected $model = TaxaEmissao::class;
    public function __construct()
    {
        $this->model = app($this->model);
    }
    


}