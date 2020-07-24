<?php
declare(strict_types=1);

namespace Iampersistent\SimpleShop\Interactor\DBal;

final class SQLToBool
{
    public function __invoke($value): bool
    {
        return (bool) $value;
    }
}
