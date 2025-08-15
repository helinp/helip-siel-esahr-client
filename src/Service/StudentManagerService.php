<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Service;

use Helip\SielEsahrClient\Dto\StudentAdd\StudentDetailsRequestDto;
use Helip\SielEsahrClient\Dto\Student\StudentDetailsResponseDto;
use Helip\SielEsahrClient\Dto\StudentSearch\StudentSearchCombinaisonRequestDto;
use Helip\SielEsahrClient\Enum\GenderCodeEnum;
use Helip\SielEsahrClient\Exception\EsahrApiException;
use Helip\SielEsahrClient\Exception\EsahrApiResponseException;
use Helip\SielEsahrClient\Http\Client\StudentSaveClient;
use Helip\SielEsahrClient\Http\Client\StudentSearchClient;
use Helip\SielEsahrClient\ValueObject\BirthDate;
use Helip\SielEsahrClient\ValueObject\FirstName;
use Helip\SielEsahrClient\ValueObject\GenderCode;
use Helip\SielEsahrClient\ValueObject\LastName;
use Helip\SielEsahrClient\ValueObject\Ssin;
use RuntimeException;
use Throwable;

final class StudentManagerService
{
    public function __construct(
        private StudentSearchClient $searchClient,
        private StudentSaveClient $addClient
    ) {
    }

    /**
     * Crée un élève s'il n'existe pas déjà, en fonction des critères de recherche.
     *
     * @param string                   $accessToken Le token d'accès pour l'API
     *                                              ESAHR.
     * @param StudentDetailsRequestDto $studentDto  Les détails de l'élève à
     *                                              créer.
     *
     * @return StudentDetailsResponseDto L'élève trouvé ou créé.
     *
     * @throws RuntimeException Si une erreur survient lors de la recherche ou de la création de l'élève.
     * @throws EsahrApiResponseException Si la réponse de l'API ESAHR est inattendue.
     *
     * @notes L'api renvoie l'erreur 409 si l'élève que l'on cherche de sauver existe déjà.
     * => cela n'est pas géré ici, car on fait une recherche avant de tenter de le créer
     * et on retourne l'élève trouvé.
     */
    public function createIfNotExists(
        string $accessToken,
        StudentDetailsRequestDto $studentDto
    ): StudentDetailsResponseDto {

        // On crée un DTO de recherche basé sur les informations de l'élève
        $searchCombinationDto = $this->getSearchDtoFromStudentDetails($studentDto);

        try {
            $multipleResponses = $this->searchClient->searchByCombination(
                $accessToken,
                $searchCombinationDto
            );

            if ($multipleResponses->total === 1) {
                // Un seul élève trouvé, on le retourne
                return $multipleResponses->items[0];
            }

            if ($multipleResponses->total > 1) {
                throw new RuntimeException('Plusieurs élèves trouvés pour la combinaison. Veuillez affiner la recherche.');
            }

            throw new EsahrApiResponseException('Réponse API inattendue : aucun élève trouvé mais pas d’erreur 404.');
        } catch (EsahrApiException $e) {
            // Cas attendu : aucun élève trouvé (404)
            if ($e->problemDetails->status === 404) {
                try {
                    return $this->addClient->save($accessToken, $studentDto);
                } catch (Throwable $e) {
                    throw new RuntimeException('Impossible de sauvegarder l’élève : ' . $e->getMessage(), 0, $e);
                }
            }

            // Cas non prévu : autre erreur API
            throw new EsahrApiResponseException('Code d’erreur ' . $e->problemDetails->status . ' inattendu : ' . $e->getMessage(), 0, $e);
        } catch (EsahrApiResponseException $e) {
            // On laisse passer tel quel pour correspondre au PHPDoc
            throw $e;
        } catch (Throwable $e) {
            throw new RuntimeException('Erreur lors de la recherche ou de la création de l’élève : ' . $e->getMessage(), 0, $e);
        }
    }

    private function getSearchDtoFromStudentDetails(
        StudentDetailsRequestDto $studentDto
    ): StudentSearchCombinaisonRequestDto {
        $genderEnum = $studentDto->genderCode ? GenderCodeEnum::tryFrom($studentDto->genderCode) : null;
        $genderCode = $genderEnum ? new GenderCode($genderEnum->value) : null;

        $searchDto = new StudentSearchCombinaisonRequestDto(
            ssin: new Ssin($studentDto->ssin),
            lastName: new LastName($studentDto->lastName),
            firstName: $studentDto->firstName ? new FirstName($studentDto->firstName) : null,
            birthDate: $studentDto->birth ? new BirthDate($studentDto->birth->format('Y-m-d')) : null,
            genderCode: $genderCode
        );

        return $searchDto;
    }
}
