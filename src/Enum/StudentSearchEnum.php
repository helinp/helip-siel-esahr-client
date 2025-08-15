<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Enum;

/**
 * Enumération des champs valides pour rechercher un élève.
 */
enum StudentSearchEnum: string
{
    case SSIN        = 'ssin';
    case LAST_NAME   = 'lastName';
    case FIRST_NAME  = 'firstName';
    case BIRTH_DATE  = 'birthDate';
    case GENDER_CODE = 'genderCode';
}
