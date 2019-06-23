<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Interactor;

use IamPersistent\SimpleShop\Entity\Product;

interface SaveProductInterface
{
    public function save(Product $product): bool;
}
