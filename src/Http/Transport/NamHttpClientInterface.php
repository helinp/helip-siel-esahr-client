<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Http\Transport;

interface NamHttpClientInterface
{
    /**
     * Effectue une requête GET vers le serveur NAM avec un token Bearer
     * et des paramètres de query supplémentaires.
     *
     * @param string $path        Chemin relatif (ex: 'userinfo')
     * @param string $accessToken Token d’accès Bearer
     * @param array  $query       Paramètres de requête
     *
     * @return array
     */
    public function get(string $path, string $accessToken, array $query = []): array;

    /**
     * Effectue une requête POST vers le serveur NAM avec un token Bearer
     * et un corps JSON incluant client_id, client_secret, etc.
     *
     * @param string $path        Chemin relatif (ex: 'revoke')
     * @param string $accessToken Token d’accès Bearer
     * @param array  $json        Corps de la requête
     *
     * @return array
     */
    public function post(string $path, string $accessToken, array $json = []): array;
}
