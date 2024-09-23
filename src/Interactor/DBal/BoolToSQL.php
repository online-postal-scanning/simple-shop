<?php
declare(strict_types=1);

namespace OLPS\SimpleShop\Interactor\DBal;

final class BoolToSQL
{
    public function __invoke($bool): int
    {
        return (int) $bool;
    }
}
