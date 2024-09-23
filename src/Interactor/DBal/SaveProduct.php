<?php
declare(strict_types=1);

namespace OLPS\SimpleShop\Interactor\DBal;

use IamPersistent\Money\Interactor\MoneyToJson;
use OLPS\SimpleShop\Entity\Product;
use OLPS\SimpleShop\Interactor\ObjectHasId;
use OLPS\SimpleShop\Interactor\SaveProductInterface;

final class SaveProduct extends DBalCommon implements SaveProductInterface
{
    public function save(Product $product): bool
    {
        if ((new ObjectHasId)($product)) {
            return $this->updateData($product);
        } else {
            return $this->insertData($product);
        }
    }

    private function insertData(Product $product): bool
    {
        $data = $this->prepDataForPersistence($product);

        $response = $this->connection->insert('products', $data);
        if (1 === $response) {
            $id = $this->connection->lastInsertId();
            $product->setId($id);

            return $this->setProductCategories($product);
        } else {
            return false;
        }
    }

    private function updateData(Product $product): bool
    {
        $data = $this->prepDataForPersistence($product);

        $response = $this->connection->update('products', $data, $product->getId());

        return $this->setProductCategories($product);
    }

    private function prepDataForPersistence(Product $product): array
    {
        $moneyToJson = (new MoneyToJson());
        $boolToSQL = (new BoolToSQL);

        return [
            'active' => $boolToSQL($product->isActive()),
            'description' => $product->getDescription(),
            'name' => $product->getName(),
            'price' => $moneyToJson($product->getPrice()),
            'taxable' => $boolToSQL($product->isTaxable()),
        ];
    }

    private function setProductCategories(Product $product): bool
    {
        $this->connection->delete('product_categories', ['product_id' => $product->getId()]);

        $inserts = [];
        foreach ($product->getCategories() as $category) {
            $inserts = [

            ];
        }

        if (empty($inserts)) {
            return true;
        }

        $this->connection->insert('product_categories', $inserts);

        return true;
    }
}
