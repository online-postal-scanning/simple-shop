<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Interactor;

interface FindProductsByCategoriesInterface
{
    /**
     * @param string[] $categories
     *
     * @return \IamPersistent\SimpleShop\Entity\Product[]|[]
     */
    public function find(array $categories): array;
}
