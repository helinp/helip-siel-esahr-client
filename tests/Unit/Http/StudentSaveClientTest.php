<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Tests\Unit\Http;

use DateTimeImmutable;
use Helip\SielEsahrClient\Dto\Student\GuardianDetailDto;
use Helip\SielEsahrClient\Dto\Student\StudentDetailResponseDto;
use Helip\SielEsahrClient\Dto\StudentAdd\StudentDetailsRequestDto;
use Helip\SielEsahrClient\Dto\Student\StudentDetailsResponseDto;
use Helip\SielEsahrClient\Enum\GuardianCodeEnum;
use Helip\SielEsahrClient\Http\Client\NotificationListClient;
use Helip\SielEsahrClient\Http\Client\StudentSaveClient;
use Helip\SielEsahrClient\ValueObject\GuardianCode;
use Helip\SielEsahrClient\ValueObject\IdEsahr;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;

#[CoversClass(StudentSaveClient::class)]
final class StudentSaveClientTest extends ClientTestAbstract
{
    protected function getRequestMock(): StudentDetailsRequestDto
    {
        return new StudentDetailsRequestDto(
            ssin: '187851-06648',
            lastName: 'Dupont',
            firstName: 'Jean',
            otherFirstNames: ['Pierre'],
            genderCode: 'M',
            birth: new DateTimeImmutable('1990-01-01'),
            phoneNumber: '0123456789',
            gsmNumber: '0612345678',
            email: 'jean.dupont@example.com',
            encodePar: 'admin',
            encodeParParam: 'admin_param',
            privateAddress: null, // Assuming no private address for this test
            guardians: [
                new GuardianDetailDto(
                    lastName: 'Dupont',
                    firstName: 'Marie',
                    guardianCode: new GuardianCode(GuardianCodeEnum::PARENT->value),
                    phoneNumber: '0987654321',
                    gsmNumber: '0698765432',
                    email: '',
                    privateAddress: null, // Assuming no private address for this guardian
                    sameAddressFlag: true,
                )
            ]
        );
    }

    public function setUp(): void
    {
        parent::setUp();

        $this->setUpTest(
            mockFileName: 'student_add_response.json',
            clientClassName: StudentSaveClient::class,
            endpoint: 'students',
        );
    }

    #[CoversMethod(NotificationListClient::class, 'save')]
    public function testSaveResponseDTO(): void
    {
        // Délègue au test générique défini dans l’abstraite
        $response = $this->getClientResponse(
            testedMethodName: 'save',
            httpMethodName: 'post'
        );

        $this->assertInstanceOf(StudentDetailsResponseDto::class, $response);
        $this->assertSame((new IdEsahr('123456-01'))->value(), $response->idEsahr->value());

        $cfwbDetails = $response->cfwbDetails;
        $this->assertInstanceOf(StudentDetailResponseDto::class, $cfwbDetails);
        $this->assertSame('Dupont', $cfwbDetails->lastName);
        $this->assertSame('Jean', $cfwbDetails->firstName);

        $rnDetails = $response->rnDetails;
        $this->assertInstanceOf(StudentDetailResponseDto::class, $rnDetails);
        $this->assertSame('Dupont', $rnDetails->lastName);
        $this->assertSame('Jean', $rnDetails->firstName);
    }
}
