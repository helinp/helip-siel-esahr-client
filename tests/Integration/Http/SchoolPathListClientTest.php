<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Tests\Integration\Http;

use Helip\SielEsahrClient\Dto\SchoolPath\SchoolPathRequestDto;
use Helip\SielEsahrClient\Dto\SchoolPath\SchoolPathsResponseDto;
use Helip\SielEsahrClient\Http\Client\SchoolPathListClient;
use Helip\SielEsahrClient\Tests\Abstract\AbstractEsahrClient;
use Helip\SielEsahrClient\ValueObject\IdEsahr;

final class SchoolPathListClientTest extends AbstractEsahrClient
{
    private SchoolPathListClient $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = new SchoolPathListClient($this->httpClient);
    }

    public function testListReturnsSchoolPathsResponseDto(): void
    {
        $accessToken = $this->getAccessToken();

        $request = new SchoolPathRequestDto(
            idEsahr: new IdEsahr('14434-78'),
        );

        $result = $this->client->list($accessToken, $request);

        $this->assertInstanceOf(SchoolPathsResponseDto::class, $result);
    }
}
