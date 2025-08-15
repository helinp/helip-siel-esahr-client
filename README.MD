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

Ton README est déjà clair et professionnel, mais la section **Tests** est minimaliste et ne reflète pas tout ce que ton projet propose.
Vu que tu as un pipeline CI, un groupe `@group integration` et des scripts Composer (`test`, `coverage`), je te propose de la réécrire pour que :

* Un développeur sache **exactement** comment exécuter les tests localement.
* Les conditions pour lancer les tests d’intégration soient explicites.
* On utilise les commandes déjà présentes dans ton `composer.json`.

## Tests

### Prérequis
- PHP 8.2+
- Composer
- Variables d’environnement ESAHR_* définies (pour les tests d’intégration) :

```bash
export ESAHR_CLIENT_ID="..."
export ESAHR_CLIENT_SECRET="..."
export ESAHR_USERNAME="..."
export ESAHR_PASSWORD="..."
export ESAHR_NAM_URL="..."
```

> ⚠️ Les tests d’intégration nécessitent un accès à un environnement ESAHR de recette ou un mock compatible.
> Ils sont marqués avec `@group integration` et peuvent être exclus ou isolés.

### Lancer tous les tests (unitaires + intégration)
Je vois le problème : tu utilises quatre backticks \`\`\`\` pour fermer les blocs de code au lieu de trois \`\`\` dans plusieurs endroits, ce qui casse le rendu Markdown.

Voici la version corrigée avec un usage propre des backticks et un style uniforme :

### Prérequis
- PHP 8.2+
- Composer
- Variables d’environnement ESAHR_* définies (pour les tests d’intégration) :


```bash
export ESAHR_CLIENT_ID="..."
export ESAHR_CLIENT_SECRET="..."
export ESAHR_USERNAME="..."
export ESAHR_PASSWORD="..."
export ESAHR_NAM_URL="..."
```

> ⚠️ Les tests d’intégration nécessitent un accès à un environnement ESAHR de recette ou un mock compatible.
> Ils sont marqués avec `@group integration` et peuvent être exclus ou isolés.

### Lancer tous les tests (unitaires + intégration)

```bash
composer test
```

### Lancer uniquement les tests unitaires

```bash
vendor/bin/phpunit --exclude-group integration
```

### Lancer uniquement les tests d’intégration

```bash
vendor/bin/phpunit --group integration
```

### Générer un rapport de couverture

```bash
composer coverage
```

Le rapport sera généré dans `build/coverage.xml` et exploitable par des outils comme Coveralls.