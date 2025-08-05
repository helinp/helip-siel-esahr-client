<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Tests\Integration\Http;

use DateTimeImmutable;
use Helip\SielEsahrClient\Dto\CoursList\CoursListeRequestDto;
use Helip\SielEsahrClient\Dto\CoursList\CoursListeResponseDto;
use Helip\SielEsahrClient\Dto\CoursList\CoursListeItemResponseDto;
use Helip\SielEsahrClient\Dto\CoursList\CoursListeCoursResponseDto;
use Helip\SielEsahrClient\Http\Client\CoursListClient;
use Helip\SielEsahrClient\Tests\Abstract\AbstractEsahrClient;

final class CoursListClientTest extends AbstractEsahrClient
{
    private CoursListClient $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = new CoursListClient($this->httpClient);
    }

    public function testListReturnsStructurallyValidResponse(): void
    {
        $accessToken = $this->getAccessToken();

        $request = new CoursListeRequestDto(
            situationDate: new DateTimeImmutable('today'),
        );

        $result = $this->client->list($accessToken, $request);

        $this->assertInstanceOf(CoursListeResponseDto::class, $result);
        $this->assertIsArray($result->items);
        $this->assertNotEmpty($result->items);
        $this->assertIsInt($result->total);
        $this->assertGreaterThanOrEqual(0, $result->total);

        $item = $result->items[0];
        $this->assertInstanceOf(CoursListeItemResponseDto::class, $item);

        $this->assertIsString($item->codeDomaine);
        $this->assertIsString($item->codeFiliere);
        $this->assertIsInt($item->codeCours);
        $this->assertIsString($item->descrCourte);
        $this->assertIsString($item->descrLongue);
        $this->assertIsString($item->anneeList);
    }
}
