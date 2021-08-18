<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Interactor;

use IamPersistent\SimpleShop\Entity\Product;

interface FindProductByIdInterface
{
    public function find(string $id): ?Product;
}
