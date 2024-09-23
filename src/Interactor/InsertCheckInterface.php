<?php
declare(strict_types=1);

namespace OLPS\SimpleShop\Interactor;

use OLPS\SimpleShop\Entity\Check;

interface InsertCheckInterface
{
    public function insert(Check $check): bool;
}
