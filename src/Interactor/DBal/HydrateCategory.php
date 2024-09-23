<?php
declare(strict_types=1);

namespace OLPS\SimpleShop\Interactor\DBal;

use OLPS\SimpleShop\Entity\Category;

final class HydrateCategory
{
    public function __invoke(array $data): Category
    {
        return (new Category())
            ->setId($data['id'])
            ->setName($data['name']);
    }
}
