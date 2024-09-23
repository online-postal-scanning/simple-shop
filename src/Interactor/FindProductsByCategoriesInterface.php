<?php
declare(strict_types=1);

namespace OLPS\SimpleShop\Interactor;

interface FindProductsByCategoriesInterface
{
    /**
     * @param string[] $categories
     *
     * @return \OLPS\SimpleShop\Entity\Product[]|[]
     */
    public function find(array $categories): array;
}
