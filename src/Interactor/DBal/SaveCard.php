<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Interactor\DBal;

use IamPersistent\SimpleShop\Entity\CreditCard;
use IamPersistent\SimpleShop\Interactor\SaveCardInterface;

final class SaveCard extends DBalCommon implements SaveCardInterface
{
    public function save(CreditCard $card): bool
    {

    }
}