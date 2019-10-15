<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Interactor\DBal;

final class GatherCategoryDataForProduct extends DBalCommon
{
    public function gather(int $productId): array
    {
        return $this->connection->fetchAll($this->sql($productId));
    }

    private function sql(int $productId): string
    {
        return <<<SQL
SELECT categories.* 
FROM categories
LEFT JOIN product_categories pc on categories.id = pc.category_id
WHERE pc.product_id = $productId;
SQL;
    }
}
