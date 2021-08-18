<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Interactor\DBal;

use Doctrine\DBAL\Connection;
use IamPersistent\SimpleShop\Entity\Product;
use IamPersistent\SimpleShop\Interactor\FindProductByIdInterface;

final class FindProductById extends DBalCommon implements FindProductByIdInterface
{
    /** @var \IamPersistent\SimpleShop\Interactor\DBal\GatherCategoryDataForProduct */
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
