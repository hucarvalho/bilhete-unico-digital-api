<?php

namespace App\Models;

use Database\Factories\PassageiroFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Passageiro extends Authenticatable implements JWTSubject
{
    use HasFactory, HasApiTokens;

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
        'password',
    ];

    protected $hidden = [
        'senhaPassageiro',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function cartaoPassageiro(){
        return $this->hasMany(CartaoPassageiro::class);
    }

    public function bilhetes(){
        return $this->hasMany(Bilhete::class);
    }

    public function acaos(){
       return  $this->hasMany(Acao::class);
    }
    public function codigos(){
        return  $this->hasMany(Codigo::class);
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
