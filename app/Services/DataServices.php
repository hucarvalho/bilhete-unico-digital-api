<?php 

namespace App\Services;

use Illuminate\Support\Facades\Http;

class DataServices
{
   
    public static function qrCodeFetch($content)
    {
        $content = "id-".$content;
        $response = Http::get('http://api.qrserver.com/v1/create-qr-code/?size=250x250&data='.$content);
        $qrCode = $response->transferStats->getHandlerStats();
        return $qrCode['url']; 
    }
}