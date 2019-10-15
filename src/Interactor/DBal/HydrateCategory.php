<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Interactor\DBal;

use IamPersistent\SimpleShop\Entity\Category;

final class HydrateCategory
{
    public function __invoke(array $data): Category
    {
        return (new Category())
            ->setId($data['id'])
            ->setName($data['name']);
    }
}
