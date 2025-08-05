<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\ValueObject;

use Helip\SielEsahrClient\Contract\EnumCodeValueObjectInterface;
use UnitEnum;
use BackedEnum;
use Helip\SielEsahrClient\Contract\LabeledEnumInterface;
use InvalidArgumentException;

abstract class AbstractEnumCodeValueObject implements EnumCodeValueObjectInterface
{
    protected BackedEnum $enum;

    public function __construct(string|int $value)
    {
        $enumClass = static::getEnumClass();

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

        $choices = [];
        foreach ($enumClass::cases() as $case) {
            $choices[$case->label()] = $case->value;
        }

        return $choices;
    }

    /**
     * @return class-string<LabeledEnumInterface>
     */
    abstract protected static function getEnumClass(): string;
}
