<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\ValueObject;

use Helip\SielEsahrClient\Contract\EnumCodeValueObjectInterface;
use BackedEnum;
use Helip\SielEsahrClient\Contract\LabeledEnumInterface;
use InvalidArgumentException;
use LogicException;

/**
 * Base pour Value Objects encapsulant un BackedEnum.
 * Valide la valeur, fournit value(), label() et choices().
 * La sous-classe doit définir l'enum cible via getEnumClass().
 */
abstract class AbstractEnumCodeValueObject implements EnumCodeValueObjectInterface
{
    protected BackedEnum $enum;

    public function __construct(string|int $value)
    {
        $enumClass = static::getEnumClass();

        // Vérifications runtime minimales
        if (!enum_exists($enumClass)) {
            throw new LogicException(sprintf(
                '%s::getEnumClass() doit retourner une classe enum valide, reçu : %s',
                static::class,
                $enumClass
            ));
        }
        if (!is_subclass_of($enumClass, BackedEnum::class)) {
            throw new LogicException(sprintf(
                'L’enum %s doit être un BackedEnum (enum à valeur).',
                $enumClass
            ));
        }

        try {
            $this->enum = $enumClass::from($value);
        } catch (\ValueError $e) {
            throw new InvalidArgumentException(sprintf("Invalid value '%s' for enum %s", $value, $enumClass));
        }
    }

    public function value(): string|int
    {
        return $this->enum->value;
    }

    public function label(): string
    {
        return $this->enum instanceof LabeledEnumInterface
            ? $this->enum->label()
            : (string) $this->enum->value;
    }

    public function __toString(): string
    {
        return (string) $this->value();
    }

    public static function choices(): array
    {
        $enumClass = static::getEnumClass();
        $choices   = [];
        foreach ($enumClass::cases() as $case) {
            $label           = $case instanceof LabeledEnumInterface ? $case->label() : (string) $case->value;
            $choices[$label] = $case->value;
        }
        return $choices;
    }

    /**
     * @return class-string<BackedEnum>
     */
    abstract protected static function getEnumClass(): string;
}
