<?php
declare(strict_types=1);

namespace OLPS\SimpleShop\Interactor;

use OLPS\SimpleShop\Entity\CreditCard;

interface FindCardByIdInterface
{
    public function find($id): ?CreditCard;
}
