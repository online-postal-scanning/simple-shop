<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Interactor;

use IamPersistent\SimpleShop\Entity\CreditCard;

interface SaveCardInterface
{
    public function save(CreditCard $card): bool;
}