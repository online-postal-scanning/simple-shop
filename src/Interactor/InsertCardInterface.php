<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Interactor;

use IamPersistent\SimpleShop\Entity\CreditCard;

interface InsertCardInterface
{
    public function insert(CreditCard $card): bool;
}