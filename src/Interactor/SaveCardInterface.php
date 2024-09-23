<?php
declare(strict_types=1);

namespace OLPS\SimpleShop\Interactor;

use OLPS\SimpleShop\Entity\CreditCard;

interface SaveCardInterface
{
    public function save(CreditCard $card): bool;
}
