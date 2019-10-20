<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Interactor\DBal;

use Doctrine\DBAL\Connection;
use IamPersistent\SimpleShop\Entity\Product;
use IamPersistent\SimpleShop\Interactor\FindProductByNameInterface;

final class FindProductByName extends DBalCommon implements FindProductByNameInterface
{
    /** @var \IamPersistent\SimpleShop\Interactor\DBal\GatherCategoryDataForProduct */
    private $gatherCategoryData;

    public function __construct(Connection $connection)
    {
        parent::__construct($connection);
        $this->gatherCategoryData = new GatherCategoryDataForProduct($connection);
    }

    public function find(string $name): ?Product
    {
        $sql = "SELECT * FROM products WHERE name='$name'";

        $productData = $this->connection->fetchAssoc($sql);
        if (empty($productData)) {
            return null;
        }
        $productData['categories'] = $this->gatherCategoryData->gather((int) $productData['id']);

        return (new HydrateProduct)($productData);
    }
}
