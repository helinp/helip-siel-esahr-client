[![CI](https://github.com/helinp/helip-siel-esahr-client/actions/workflows/ci.yml/badge.svg?branch=dev)](https://github.com/helinp/helip-siel-esahr-client/actions/workflows/ci.yml) [![Coverage Status](https://coveralls.io/repos/github/helinp/helip-siel-esahr-client/badge.svg)](https://coveralls.io/github/helinp/helip-siel-esahr-client) [![License](https://img.shields.io/badge/license-LGPL%20v3-blue.svg)](LICENSE)

# SIEL ESAHR Client PHP

Bibliothèque PHP pour interagir avec l’API REST SIEL-ESAHR développée par l’ETNIC (Fédération Wallonie-Bruxelles).  
Elle fournit des clients HTTP, des DTO et une gestion de l’authentification OAuth2.

> **Note :** Cette librairie est développée indépendamment de l’ETNIC.  
> **Statut :** *Work In Progress* — API et implémentations susceptibles d’évoluer.

---

## Exemple d’utilisation

```php
<?php

use Helip\SielEsahrClient\Http\OAuth\OAuthTokenProvider;
use Helip\SielEsahrClient\Http\OAuth\FileTokenStorage;
use Helip\SielEsahrClient\Dto\OAuth\Credentials;
use Helip\SielEsahrClient\Http\Client\StudentSearchClient;
use Helip\SielEsahrClient\Http\Client\StudentSaveClient;
use Helip\SielEsahrClient\Http\Client\CommuneSearchClient;
use Helip\SielEsahrClient\Dto\StudentSearch\StudentSearchIdEsahrRequestDto;
use Helip\SielEsahrClient\Dto\StudentAdd\StudentDetailsRequestDto;
use Helip\SielEsahrClient\Dto\Student\GuardianDetailDto;
use Helip\SielEsahrClient\Dto\CommuneSearch\CommuneSearchRequestDto;
use Helip\SielEsahrClient\Enum\GuardianCodeEnum;
use Helip\SielEsahrClient\Exception\EsahrApiException;
use Helip\SielEsahrClient\ValueObject\IdEsahr;
use Helip\SielEsahrClient\ValueObject\GuardianCode;
use DateTimeImmutable;
use Symfony\Component\HttpClient\HttpClient;

// 1. Définir les credentials
$httpClient = HttpClient::create(['timeout' => 5]);
$credentials = new Credentials(
    $_ENV['ESAHR_CLIENT_ID'],
    $_ENV['ESAHR_CLIENT_SECRET'],
    $_ENV['ESAHR_USERNAME'],
    $_ENV['ESAHR_PASSWORD'],
    $_ENV['ESAHR_NAM_URL'],
);

// 2. Créer un stockage de jeton (ici fichier local, mais vous pouvez fournir le vôtre)
$storage = new FileTokenStorage('/srv/monapp/tmp/token.json');

// 3. Initialiser le provider OAuth
$tokenProvider = new OAuthTokenProvider($httpClient, $credentials, $storage);
$accessToken = $tokenProvider->getAccessToken();

// 4. Rechercher un élève
try {
    $studentSearch = new StudentSearchClient($httpClient);
    $student = $studentSearch->searchByEsahrId(
        $accessToken,
        new StudentSearchIdEsahrRequestDto(new IdEsahr('123456-01'), new DateTimeImmutable('2023-01-01'))
    );
    echo "Élève : {$student->cfwbDetails->lastName} {$student->cfwbDetails->firstName}\n";
} catch (EsahrApiException $e) {
    echo "Erreur recherche élève : {$e->problemDetails->title} - {$e->problemDetails->detail}\n";
}

// 5. Sauver un élève
try {
    $studentSave = new StudentSaveClient($httpClient);
    $newStudent = new StudentDetailsRequestDto(
        '187851-06648', 'Dupont', 'Jean', ['Pierre'], 'M',
        new DateTimeImmutable('1990-01-01'),
        '0123456789', '0612345678', 'jean.dupont@example.com',
        'admin', 'admin_param', null, [
            new GuardianDetailDto('Dupont', 'Marie', new GuardianCode(GuardianCodeEnum::PARENT->value), '0987654321', '0698765432', '', null, true)
        ]
    );
    $saved = $studentSave->save($accessToken, $newStudent);
    echo "Élève créé : {$saved->idEsahr->value()}\n";
} catch (EsahrApiException $e) {
    echo "Erreur sauvegarde élève : {$e->problemDetails->title} - {$e->problemDetails->detail}\n";
}

// 6. Rechercher une commune
try {
    $communeClient = new CommuneSearchClient($httpClient);
    $communes = $communeClient->search($accessToken, new CommuneSearchRequestDto('Bruxelles', '1190'));
    foreach ($communes->items as $item) {
        echo "Code INS: {$item->codeIns}, Commune: {$item->nameCommune}, CP: {$item->postalCode}\n";
    }
} catch (EsahrApiException $e) {
    echo "Erreur recherche commune : {$e->problemDetails->title} - {$e->problemDetails->detail}\n";
}
```

---

## Gestion du stockage de jeton OAuth

Le `OAuthTokenProvider` ne garde pas le jeton en mémoire entre deux instanciations.
C’est pourquoi il délègue la persistance à une implémentation de `TokenStorageInterface` :

```php
interface TokenStorageInterface
{
    public function save(string $token, DateTimeImmutable $expiresAt): void;

    /**
     * @return array{token: string, expiresAt: DateTimeImmutable}|null
     */
    public function load(): ?array;
}
```
---

## TODOs

### Tests

* [ ] Couvrir l'ensemble du code (objectif : 100 % coverage PHPUnit ^^)
* [ ] Couvrir plus amplement les réponses JSON (assertions sur les clés de la réponse)
* [ ] Réduire et consolider les tests d’intégration

### Fonctionnalités

* [ ] Date de naissance élève — permettre la saisie d'une année seule (actuellement parsée comme un `DateTimeImmutable` complet).