[![CI](https://github.com/helinp/helip-siel-esahr-client/actions/workflows/ci.yml/badge.svg?branch=dev)](https://github.com/helinp/helip-siel-esahr-client/actions/workflows/ci.yml) [![Coverage Status](https://coveralls.io/repos/github/helinp/helip-siel-esahr-client/badge.svg)](https://coveralls.io/github/helinp/helip-siel-esahr-client) [![License](https://img.shields.io/badge/license-LGPL%20v3-blue.svg)](LICENSE)

# ESAHR Client PHP

Bibliothèque PHP pour interagir avec l’API REST SIEL-ESAHR développée par l’ETNIC (Fédération Wallonie-Bruxelles).
Elle fournit des clients HTTP et des DTO pour communiquer avec le service SIEL-ESAHR.

> **Note :** Cette librairie est développée indépendamment de l’ETNIC.
> Elle n’est pas un outil officiel et n’est pas supportée par l’ETNIC.
> **Statut :** *Work In Progress* — API et implémentations susceptibles d’évoluer.

---

## Installation

```bash
composer require helip/siel-esahr-client
```
---
## Exemple d’utilisation

```php
<?php

use Helip\SielEsahrClient\Http\OAuth\OAuthTokenProvider;
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

// 1. Obtenir un jeton OAuth
$httpClient = HttpClient::create(['timeout' => 5]);
$credentials = new Credentials(
    $_ENV['ESAHR_CLIENT_ID'],
    $_ENV['ESAHR_CLIENT_SECRET'],
    $_ENV['ESAHR_USERNAME'],
    $_ENV['ESAHR_PASSWORD'],
    $_ENV['ESAHR_NAM_URL'],
    'profile',
    'password'
);
$tokenProvider = new OAuthTokenProvider($httpClient, $credentials);
$accessToken = $tokenProvider->getAccessToken();

// 2. Rechercher un élève
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

// 3. Sauver un élève
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

// 4. Rechercher une commune
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
## TODOs

### Tests
- [ ] Couvrir plus amplement les réponses JSON (assertions sur les clés de la réponse)  
- [ ] Couvrir l'ensemble du code (objectif : 100 % coverage PHPUnit)  
- [ ] Réduire les tests d’intégration à un plan minimal (OAuth, GET simple, POST simple) et isoler via `@group integration`.  

### Fonctionnalités
- [ ] Date de naissance élève — permettre la saisie d'une année seule (actuellement parsée comme un `DateTimeImmutable` complet).  

### Améliorations
- [ ] Ajouter un `Manager` pour simplifier l'utilisation.

> ⚠️ Les tests d’intégration nécessitent un accès à un environnement ESAHR de recette ou un mock compatible.
