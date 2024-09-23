<?php
declare(strict_types=1);

namespace OLPS\SimpleShop\Interactor;

use OLPS\SimpleShop\Entity\Product;

interface FindProductByIdInterface
{
    public function find(string $id): ?Product;
}
