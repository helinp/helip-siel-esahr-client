<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Tests\Integration\Service;

use Helip\SielEsahrClient\Dto\Student\StudentResponseDto;
use Helip\SielEsahrClient\Http\Client\StudentSaveClient;
use Helip\SielEsahrClient\Http\Client\StudentSearchClient;
use Helip\SielEsahrClient\Service\StudentManagerService;
use Helip\SielEsahrClient\Tests\Abstract\AbstractEsahrClient;
use Helip\SielEsahrClient\Tests\Mock\StudentDtoFactory;

final class StudentManagerTest extends AbstractEsahrClient
{
    private StudentManagerService $manager;

    protected function setUp(): void
    {
        parent::setUp();
        $this->manager = new StudentManagerService(
            searchClient: new StudentSearchClient($this->httpClient),
            addClient: new StudentSaveClient($this->httpClient)
        );
    }

    public function testCreateIfNotExistsAddsAndReturnsStudent(): void
    {
        $accessToken = $this->getAccessToken();

        $studentDto = StudentDtoFactory::createMinorWithGuardians();

        $response = $this->manager->createIfNotExists($accessToken, $studentDto);

        $this->assertInstanceOf(StudentResponseDto::class, $response);
    }
}
