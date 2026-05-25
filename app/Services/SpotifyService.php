<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class SpotifyService
{
    private ?string $clientId;
    private ?string $clientSecret;

    public function __construct()
    {
        $this->clientId = 'e063c6224f3044e1bf137937f79a2d64'; // temporário
        $this->clientSecret = 'd37c2e518dd644f9b425d1a1ea6b1e05'; // temporário
    }

    // Gera e cacheia o token de acesso (dura 1 hora)
    public function getToken(): string
    {
        return Cache::remember('spotify_token', 3500, function () {
            $response = Http::asForm()
                ->withBasicAuth($this->clientId, $this->clientSecret)
                ->post('https://accounts.spotify.com/api/token', [
                    'grant_type' => 'client_credentials',
                ]);

            return $response->json('access_token');
        });
    }

    // Busca álbuns pelo nome (útil para o futuro)
    public function searchAlbum(string $query): array
    {
        $token = $this->getToken();

        $response = Http::withToken($token)
            ->get('https://api.spotify.com/v1/search', [
                'q' => $query,
                'type' => 'album',
                'limit' => 5,
            ]);

        return $response->json('albums.items') ?? [];
    }

    // Busca detalhes de um álbum pelo ID
    public function getAlbum(string $albumId): ?array
    {
        $token = $this->getToken();

        $response = Http::withToken($token)
            ->get("https://api.spotify.com/v1/albums/{$albumId}");

        return $response->successful() ? $response->json() : null;
    }
}