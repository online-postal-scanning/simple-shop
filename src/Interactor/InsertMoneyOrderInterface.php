<?php
declare(strict_types=1);

namespace OLPS\SimpleShop\Interactor;

use OLPS\SimpleShop\Entity\MoneyOrder;

interface InsertMoneyOrderInterface
{
    public function insert(MoneyOrder $check): bool;
}
