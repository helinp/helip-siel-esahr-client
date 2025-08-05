<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Tests\Mock;

use DateTimeImmutable;
use Helip\SielEsahrClient\Dto\Common\CityDto;
use Helip\SielEsahrClient\Dto\Common\PrivateAddressDto;
use Helip\SielEsahrClient\Dto\Student\GuardianDetailDto;
use Helip\SielEsahrClient\Dto\StudentAdd\StudentDetailsRequestDto;
use Helip\SielEsahrClient\Enum\GuardianCodeEnum;
use Helip\SielEsahrClient\ValueObject\GuardianCode;

final class StudentDtoFactory
{
    public static function createMinorWithGuardians(): StudentDetailsRequestDto
    {
        return new StudentDetailsRequestDto(
            ssin: '15810100107',
            lastName: 'Testeleve',
            firstName: 'Léo',
            otherFirstNames: ['Mathis'],
            genderCode: 'M',
            birth: new DateTimeImmutable('2015-01-01'),
            phoneNumber: null,
            gsmNumber: '0488111222',
            email: 'leo.testeleve@example.org',
            encodePar: '',
            encodeParParam: '',
            privateAddress: new PrivateAddressDto(
                addressStreet: 'Rue du Petit Bois',
                addressNumber: '123',
                addressBox: 'A',
                addressPostal: '1040',
                addressCity: new CityDto('21004', 'ETTERBEEK'),
                addressCountry: '150' // Belgique
            ),
            guardians: [
                new GuardianDetailDto(
                    lastName: 'Parent',
                    firstName: 'Alice',
                    guardianCode: new GuardianCode(GuardianCodeEnum::PARENT->value),
                    phoneNumber: '024000001',
                    gsmNumber: '0477000001',
                    email: 'alice.parent@example.org',
                    sameAddressFlag: false,
                    privateAddress: new PrivateAddressDto(
                        addressStreet: 'Avenue des Parents',
                        addressNumber: '10',
                        addressBox: null,
                        addressPostal: '1030',
                        addressCity: new CityDto('21015', 'SCHAERBEEK'),
                        addressCountry: '150'
                    )
                ),
                new GuardianDetailDto(
                    lastName: 'Parent Second',
                    firstName: 'Marc',
                    guardianCode: new GuardianCode(GuardianCodeEnum::PARENT->value),
                    phoneNumber: '024000002',
                    gsmNumber: '0477000002',
                    email: 'marc.parent@example.org',
                    sameAddressFlag: false,
                    privateAddress: new PrivateAddressDto(
                        addressStreet: 'Boulevard de la Famille',
                        addressNumber: '22',
                        addressBox: null,
                        addressPostal: '1050',
                        addressCity: new CityDto('21014', 'IXELLES'),
                        addressCountry: '150'
                    )
                )
            ]
        );
    }
}
