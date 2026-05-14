<?php

namespace App\Http\Controllers;

use App\Services\SpotifyService;

class SpotifyController extends Controller
{
    public function __construct(protected SpotifyService $spotify) {}

    // Rota que retorna o token para o JS usar
    // GET /spotify/token
    public function token()
    {
        return response()->json([
            'token' => $this->spotify->getToken()
        ]);
    }
}