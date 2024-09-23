<?php
declare(strict_types=1);

namespace OLPS\SimpleShop\Interactor;

use OLPS\SimpleShop\Entity\CreditCard;

interface FindCardByLastFourInterface
{
    public function find($lastFour): ?CreditCard;
}
