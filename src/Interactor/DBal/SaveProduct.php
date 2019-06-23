<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Interactor\DBal;

use IamPersistent\Money\Interactor\MoneyToJson;
use IamPersistent\SimpleShop\Entity\Product;
use IamPersistent\SimpleShop\Interactor\ObjectHasId;
use IamPersistent\SimpleShop\Interactor\SaveProductInterface;

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

            return true;
        } else {
            return false;
        }
    }

    private function updateData(Product $product): bool
    {
        $data = $this->prepDataForPersistence($product);

        $response = $this->connection->update('products', $data, $product->getId());

        return true;
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
}
