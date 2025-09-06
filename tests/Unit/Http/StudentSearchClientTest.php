<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Tests\Unit\Http;

use DateTimeImmutable;
use Helip\SielEsahrClient\Dto\Student\StudentMultipleResponseDto;
use Helip\SielEsahrClient\Dto\Student\StudentDetailsResponseDto;
use Helip\SielEsahrClient\Dto\StudentAdd\StudentDetailsRequestDto;
use Helip\SielEsahrClient\Dto\StudentSearch\StudentSearchCombinaisonRequestDto;
use Helip\SielEsahrClient\Dto\StudentSearch\StudentSearchIdEsahrRequestDto;
use Helip\SielEsahrClient\Http\Client\StudentSearchClient;
use Helip\SielEsahrClient\ValueObject\BirthDate;
use Helip\SielEsahrClient\ValueObject\FirstName;
use Helip\SielEsahrClient\ValueObject\GenderCode;
use Helip\SielEsahrClient\ValueObject\IdEsahr;
use Helip\SielEsahrClient\ValueObject\LastName;
use Helip\SielEsahrClient\ValueObject\Ssin;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;

#[CoversClass(StudentSearchClient::class)]
final class StudentSearchClientTest extends ClientTestAbstract
{
    protected function getRequestMock(): ?StudentDetailsRequestDto
    {
        return null;
    }

    #[CoversMethod(StudentSearchClient::class, 'searchByEsahrId')]
    public function testSearchByEsahrIdResponseDTO(): void
    {
        $this->setUpTest(
            mockFileName: 'student_search_response.json',
            clientClassName: StudentSearchClient::class,
            endpoint: 'students/00002-42?fromDate=2023-01-01',
        );

        // Délègue au test générique défini dans l’abstraite
        $response = $this->getClientResponse(
            testedMethodName: 'searchByEsahrId',
            arguments: [
                new StudentSearchIdEsahrRequestDto(
                    idEsahr: new IdEsahr('00002-42'),
                    fromDate: new DateTimeImmutable('2023-01-01')
                )
            ],
            httpMethodName: 'get'
        );

        $this->assertInstanceOf(StudentDetailsResponseDto::class, $response);
        $this->assertSame((new IdEsahr('00002-42'))->value(), $response->idEsahr->value());
    }

    #[CoversMethod(StudentSearchClient::class, 'searchByCombination')]
    public function testSearchByCombinationResponseDTO(): void
    {
        $this->setUpTest(
            mockFileName: 'student_combination_search_response.json',
            clientClassName: StudentSearchClient::class,
            endpoint: 'students?ssin=70810100166&lastName=Doe&firstName=John&birthDate=2000-01-01&genderCode=M',
        );

        // Délègue au test générique défini dans l’abstraite
        $response = $this->getClientResponse(
            testedMethodName: 'searchByCombination',
            arguments: [
                new StudentSearchCombinaisonRequestDto(
                    ssin: new Ssin('70810100166'),
                    lastName: new LastName('Doe'),
                    firstName: new FirstName('John'),
                    birthDate: new BirthDate('2000-01-01'),
                    genderCode: new GenderCode('M')
                )
            ],
            httpMethodName: 'get'
        );

        $this->assertInstanceOf(StudentMultipleResponseDto::class, $response);
        $this->assertSame((new IdEsahr('00002-42'))->value(), $response->items[0]->idEsahr->value());
    }
}
