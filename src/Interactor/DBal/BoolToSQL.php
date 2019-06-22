<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Interactor\DBal;

final class BoolToSQL
{
    public function __invoke($bool): int
    {
        return (int) $bool;
    }
}
