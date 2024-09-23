<?php
declare(strict_types=1);

namespace OLPS\SimpleShop\Interactor\DBal;

use OLPS\SimpleShop\Entity\Product;
use OLPS\SimpleShop\Interactor\FindProductByNameInterface;
use OLPS\SimpleShop\Interactor\FindProductsByCategoriesInterface;

final class FindProductsByCategories extends DBalCommon implements FindProductsByCategoriesInterface
{
    public function find(array $categories): array
    {
        $productData = $this->gatherProductData($categories);

        $products = [];
        foreach ($productData as $data) {
            $products[] = (new HydrateProduct)($data);
        }

        return $products;
    }

    private function gatherProductData(array $categories): array
    {
        $sql = <<<SQL
        SELECT products.* FROM products
        LEFT JOIN product_categories ON products.id = product_categories.product_id
SQL;

        $productData = $this->connection->fetchAssoc($sql);

        foreach ($productData as $productDatum) {

        }

    }
}
