<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Interactor;

final class PascalCase
{
    public function __invoke(string $string, array $noStrip = []): string
    {
        return ucfirst((new CamelCase)($string, $noStrip));
    }
}