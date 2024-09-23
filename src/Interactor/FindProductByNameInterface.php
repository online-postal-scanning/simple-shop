<?php
declare(strict_types=1);

namespace OLPS\SimpleShop\Interactor;

use OLPS\SimpleShop\Entity\Product;

interface FindProductByNameInterface
{
    public function find(string $name, bool $isActive = true): ?Product;
}
