<?php
declare(strict_types=1);

namespace OLPS\SimpleShop\Interactor\DBal;

use OLPS\SimpleShop\Entity\Category;
use OLPS\SimpleShop\Interactor\ObjectHasId;
use OLPS\SimpleShop\Interactor\SaveCategoryInterface;

final class SaveCategory extends DBalCommon implements SaveCategoryInterface
{
    public function save(Category $category): bool
    {
        if ((new ObjectHasId)($category)) {
            return $this->updateData($category);
        } else {
            return $this->insertData($category);
        }
    }

    private function insertData(Category $category): bool
    {
        $this->connection->beginTransaction();

        try {
            $data = $this->prepDataForPersistence($category);

            $response = $this->connection->insert('categories', $data);
            if (1 === $response) {
                $id = $this->connection->lastInsertId();
                $category->setId($id);
            } else {
                $this->connection->rollBack();

                return false;
            }
        } catch (Exception $e) {
            $this->connection->rollBack();
        }

        $this->connection->commit();

        return true;
    }

    private function updateData(Category $category): bool
    {
        $this->connection->beginTransaction();

        try {
            $data = $this->prepDataForPersistence($category);

            $response = $this->connection->update('categories', $data, ['id' => $category->getId()]);
        } catch (Exception $e) {
            $this->connection->rollBack();

            return false;
        }

        $this->connection->commit();

        return true;
    }

    private function prepDataForPersistence(Category $category): array
    {
        return [
            'name' => $category->getName(),
        ];
    }
}
