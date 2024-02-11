<?php

namespace App\Models;

use Database\Factories\PassageiroFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Passageiro extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomePassageiro',
        'dataNascPassageiro',
        'generoPassageiro',
        'cpfPassageiro',
        'numTelPassageiro',
        'logrPassageiro',
        'numLogrPassageiro',
        'complementoLogrPassageiro',
        'ufPassageiro',
        'bairroPassageiro',
        'cepPassageiro',
        'fotoPassageiro',
        'emailPassageiro',
        'senhaPassageiro',
    ];

    protected $hidden = [
        'senhaPassageiro',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function cartaoPassageiro(){
        return $this->hasMany(CartaoPassageiro::class);
    }

    public function bilhetes(){
        return $this->hasMany(Bilhete::class);
    }

    public function acaos(){
       return  $this->hasMany(Acao::class);
    }

    protected static function newFactory()
    {
        return PassageiroFactory::new();
    }

    public function getPassageiros(String | null $search = null)
    {
        $passageiro = $this->where(function($query) use ($search){
            if($search)
            {
            
            $query->where('nomePassageiro','LIKE',"%{$search}%");
            $query->orWhere('emailPassageiro','LIKE',"%{$search}%");
            }
        })->get();     


        return $passageiro;
        
    }
}
