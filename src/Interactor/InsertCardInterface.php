<?php
declare(strict_types=1);

namespace OLPS\SimpleShop\Interactor;

use OLPS\SimpleShop\Entity\CreditCard;

interface InsertCardInterface
{
    public function insert(CreditCard $card): bool;
}
