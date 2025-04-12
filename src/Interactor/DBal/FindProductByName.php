<?php
declare(strict_types=1);

namespace OLPS\SimpleShop\Interactor\DBal;

use Doctrine\DBAL\Connection;
use OLPS\SimpleShop\Entity\Product;
use OLPS\SimpleShop\Interactor\FindProductByNameInterface;

final class FindProductByName extends DBalCommon implements FindProductByNameInterface
{
    /** @var \OLPS\SimpleShop\Interactor\DBal\GatherCategoryDataForProduct */
    private $gatherCategoryData;

    public function __construct(Connection $connection)
    {
        parent::__construct($connection);
        $this->gatherCategoryData = new GatherCategoryDataForProduct($connection);
    }

    public function find(string $name, bool $isActive = true): ?Product
    {
        $isActiveValue = (new BoolToSQL)($isActive);
        $sql = <<<SQL
SELECT * 
FROM products 
WHERE name='$name'
SQL;
        if ($isActive) {
            $sql .= ' AND active = 1';
        }
        $productData = $this->connection->fetchAssociative($sql);
        if (empty($productData)) {
            return null;
        }
        $productData['categories'] = $this->gatherCategoryData->gather((int) $productData['id']);

        return (new HydrateProduct)($productData);
    }
}
