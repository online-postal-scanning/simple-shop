<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Interactor;

use IamPersistent\SimpleShop\Entity\CreditCard;

interface FindCardByLastFourInterface
{
    public function find($lastFour): ?CreditCard;
}
