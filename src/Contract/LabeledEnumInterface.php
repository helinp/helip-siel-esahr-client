<?php

declare(strict_types=1);

namespace Helip\SielEsahrClient\Contract;

interface LabeledEnumInterface
{
    /**
     * Libellé humain lisible pour la case de l'enum.
     */
    public function label(): string;
}
