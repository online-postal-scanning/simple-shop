<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Interactor\DBal;

use IamPersistent\SimpleShop\Entity\Product;
use IamPersistent\SimpleShop\Interactor\FindProductByNameInterface;

final class FindProductByName extends DBalCommon implements FindProductByNameInterface
{
    public function find(string $name): ?Product
    {
        $sql = "SELECT * FROM products WHERE name='$name'";

        $productData = $this->connection->fetchAssoc($sql);

        return (new HydrateProduct)($productData);
    }
}
