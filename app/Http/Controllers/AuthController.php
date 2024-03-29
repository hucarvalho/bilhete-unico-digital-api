<?php

namespace App\Http\Controllers;

use App\Mail\CodeMail;
use App\Models\Codigo;
use App\Models\Passageiro;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    protected $model;
    public function __construct(Passageiro $passageiro)
    {
        $this->model = $passageiro;
    }
    public function register(Request $request, $id)
    {
        
        if($this->model->find($id)){
        $passageiro = $this->model->find($id);
        $data['password'] = bcrypt($request->password);
        
        $passageiro->update($data);
        return response()->json([
            'message' => true,
        ]);
        }else{
            return response()->json([
                'message' => false
            ]);
        }
    }
    public function login(Request $request)
    {
        $credentials = [
            'cpfPassageiro' => $request->cpfPassageiro,
            'password' => $request->password
        ];
        
        if(!$token = auth()->attempt($credentials)){
            return response()->json([
                'message' => false,
            ]);
        }
        return $this->createNewToken($token);
    }

    public function createNewToken($token)
    {
        return response()->json([
            'token_de_acesso' => $token,
            'tipo_token' => 'bearer',
            'expira_em' => JWTAuth::factory()->getTTL()*60,
            'usuario' => auth()->user()
        ]);
    }
    public function perfil()
    {
        return response()->json([
            'usuario' => auth()->user()
        ]);
    }
    public function logout()
    {
        auth()->logout();
        return response()->json("Usuario deslogado");
    }
    public function findByCpf(Request $request)
    {
        $passageiro =$this->model->where('cpfPassageiro',$request->cpfPassageiro)->get();
        if(!isset($passageiro[0]))
        {
            return response()->json([
                'message' => 'CPF não encontrado!'
            ]);
        }
        $passageiro = $passageiro[0];
        
        if($passageiro->password != null)
        {
            return response()->json([
                'message' => 'CPF já cadastrado'
            ]);
        }
        $data = [
            'id' => $passageiro->id,
            'emailPassageiro' => $passageiro->emailPassageiro,
            'numTelPassageiro' => $passageiro->numTelPassageiro
        ];
        return response()->json([
            'usuario' => $data
        ]);
    }
    public function codigoCadastro(Request $request, Codigo $codigo)
    {
        if(isset($request->emailPassageiro))
        {
            
            $code = fake()->numerify('####');
            $passageiro =$this->model->where('emailPassageiro',$request->emailPassageiro)->get();
            if(!isset($passageiro[0])){
                return response()->json([
                    'message' => 'Email não encontrado'
                ]);
            }
            $passageiro = $passageiro[0];
            $codigo->create([
                'codigo' => $code,
                'tipoCodigo' => 'Cadastro',
                'passageiro_id' => $passageiro->id,
                'wasUsed' =>false
            ]);
            try{
            // Mail::to($passageiro->emailPassageiro)
            //     ->send(new CodeMail($code, 'Cadastro', $passageiro->nomePassageiro));
                return response()->json([
                    'message' => 'sucesso ao enviar email',
                    'id' => $passageiro->id
                ]);
            }catch(Exception $e){
                return response()->json([
                    'message' => $e->getMessage()
                ]);
            } 
        }
        
    }
    public function verificaCodigo(Request $request, Codigo $codigo, $id)
    {
        if(isset($request->codigo))
        {
            $codigo = $codigo->where('codigo', $request->codigo)->where('passageiro_id', $id)->get();
            if(!isset($codigo[0])){
                return response()->json([
                    'message' => 'incorreto',
                    
                ]);
            }
            $codigo = $codigo[0];
            $codigo->update(['wasUsed' => true]);
            return response()->json([
                'message' => 'autorizado'
            ]);
        }
    }
}
