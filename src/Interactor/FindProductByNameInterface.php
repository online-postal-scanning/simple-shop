<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Interactor;

use IamPersistent\SimpleShop\Entity\Product;

interface FindProductByNameInterface
{
    public function find(string $name): ?Product;
}
