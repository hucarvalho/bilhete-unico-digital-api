<?php

namespace App\Http\Controllers;

use App\Models\Ajuda;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function chat($search)
    {
        
        $data = Ajuda::where('tituloAjuda', 'LIKE', "%{$search}%")->get()->pluck('tituloAjuda');
        return $data;
    }
}
