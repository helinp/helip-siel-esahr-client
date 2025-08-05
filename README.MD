# ESAHR Client PHP

Bibliothèque PHP pour interagir avec l’API REST **SIEL-ESAHR** développée par l’**ETNIC** (Fédération Wallonie-Bruxelles).
Elle fournit des **clients HTTP typés** et des **DTO explicites** pour communiquer avec le service ESAHR.

> **Note :** Cette librairie est développée indépendamment de l’ETNIC.
> Elle n’est pas un outil officiel et n’est pas supportée par l’ETNIC.
> **Statut :** *Work In Progress* — API et implémentations susceptibles d’évoluer.

---

## Installation

```bash
composer require helip/siel-esahr-client
```

---

## Configuration

Définissez les variables d’environnement suivantes (via `.env` ou injection dans votre application) :

```env
ESAHR_CLIENT_ID=your-client-id
ESAHR_CLIENT_SECRET=your-client-secret
ESAHR_USERNAME=your-username
ESAHR_PASSWORD=your-password
ESAHR_API_URL=https://api.example.com/external/esahr/v1/
ESAHR_NAM_URL=https://secure.example.com/nidp/oauth/nam/
```

---

## Principes

* Encapsulation complète des appels HTTP.
* Mapping bidirectionnel via **DTO** (`toArray` / `fromArray`).
* Respect des types et des contrats d’API.

---

## Exemple d’utilisation

```php
$credentials = new Credentials(...);
$httpClient = HttpClient::create(); // Symfony HttpClient

$tokenProvider = new OAuthTokenProvider($httpClient, $credentials);
$accessToken = $tokenProvider->getAccessToken();

$client = new StudentSearchClient(
    new EsahrHttpClient($httpClient, $_ENV['ESAHR_API_URL'])
);
$dto = $client->searchByEsahrId($accessToken, new IdEsahr('1234567890-12'));
```

---

## Clients disponibles

| Domaine             | Méthode | Client                       | Description                                |
| ------------------- | ------- | ---------------------------- | ------------------------------------------ |
| OAuth               | POST    | OAuthTokenProvider           | Authentification (grant\_type=password)    |
|                     | POST    | TokenRevocationClient        | Révocation du token                        |
|                     | GET     | UserInfoClient               | Informations utilisateur                   |
| Étudiant            | GET     | StudentSearchClient          | Rechercher un élève                        |
|                     | POST    | StudentSaveClient            | Créer un élève                             |
|                     | PUT     | StudentModifyClient          | Modifier un élève                          |
| Notifications       | GET     | NotificationListClient       | Liste des notifications                    |
| Cours               | GET     | CoursListClient              | Liste des cours                            |
|                     | POST    | CoursSaveClient              | Ajouter une inscription                    |
|                     | GET     | InscriptionCoursSearchClient | Rechercher les inscriptions                |
|                     | PUT     | InscriptionCoursUpdateClient | Modifier une inscription                   |
| Parcours scolaire   | GET     | SchoolPathListClient         | Voir le parcours d’un élève                |
| Droit d’inscription | GET     | DroitInscriptionSearchClient | Vérifier si un élève a droit de s’inscrire |

---

## Tests

```bash
phpunit
```

> Les tests d’intégration nécessitent un accès à un environnement ESAHR de recette ou un mock compatible.

---

## Licence

Code distribué sous **LGPL v3**.