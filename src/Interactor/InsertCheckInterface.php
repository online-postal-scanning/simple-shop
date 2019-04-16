<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Interactor;

use IamPersistent\SimpleShop\Entity\Check;

interface InsertCheckInterface
{
    public function insert(Check $check): bool;
}
