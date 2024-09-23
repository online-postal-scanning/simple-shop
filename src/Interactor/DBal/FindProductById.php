<?php
declare(strict_types=1);

namespace OLPS\SimpleShop\Interactor\DBal;

use Doctrine\DBAL\Connection;
use OLPS\SimpleShop\Entity\Product;
use OLPS\SimpleShop\Interactor\FindProductByIdInterface;

final class FindProductById extends DBalCommon implements FindProductByIdInterface
{
    /** @var \OLPS\SimpleShop\Interactor\DBal\GatherCategoryDataForProduct */
    private $gatherCategoryData;

    public function __construct(Connection $connection)
    {
        parent::__construct($connection);
        $this->gatherCategoryData = new GatherCategoryDataForProduct($connection);
    }

    public function find($id): ?Product
    {
        $sql = "SELECT * FROM products WHERE id='$id'";

        $productData = $this->connection->fetchAssoc($sql);
        if (empty($productData)) {
            return null;
        }
        $productData['categories'] = $this->gatherCategoryData->gather((int) $id);

        return (new HydrateProduct)($productData);
    }
}
