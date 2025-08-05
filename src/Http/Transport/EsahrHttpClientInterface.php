<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Http\Transport;

interface EsahrHttpClientInterface
{
    /**
     * Effectue une requête GET authentifiée vers l’API ESAHR.
     *
     * @param string $path        Chemin relatif (ex: 'students')
     * @param string $accessToken Token d’accès Bearer
     * @param array  $query       Paramètres de requête (optionnels)
     *
     * @return array
     */
    public function get(string $path, string $accessToken, array $query = []): array;

    /**
     * Effectue une requête POST authentifiée vers l’API ESAHR.
     *
     * @param string $path        Chemin relatif (ex: 'students')
     * @param string $accessToken Token d’accès Bearer
     * @param array  $json        Données JSON à envoyer
     *
     * @return array
     */
    public function post(string $path, string $accessToken, array $json = []): array;

    /**
     * Effectue une requête PUT authentifiée vers l’API ESAHR.
     *
     * @param string $path        Chemin relatif (ex: 'students')
     * @param string $accessToken Token d’accès Bearer
     * @param array  $json        Données JSON à envoyer
     *
     * @return array
     */
    public function put(string $path, string $accessToken, array $json = []): array;
}
