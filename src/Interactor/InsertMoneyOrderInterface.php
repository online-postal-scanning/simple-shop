<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Interactor;

use IamPersistent\SimpleShop\Entity\MoneyOrder;

interface InsertMoneyOrderInterface
{
    public function insert(MoneyOrder $check): bool;
}
