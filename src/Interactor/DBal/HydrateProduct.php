<?php
declare(strict_types=1);

namespace OLPS\SimpleShop\Interactor\DBal;


use OLPS\Money\JsonToMoney;
use OLPS\SimpleShop\Interactor\DBal\SQLToBool;
use OLPS\SimpleShop\Entity\Product;

final class HydrateProduct
{
    public function __invoke($data): Product
    {
        $categories = $this->hydrateCategories($data);
        $sqlToBool = (new SQLToBool());
        $jsonToMoney = (new JsonToMoney());

        return (new Product())
            ->setActive($sqlToBool($data['active']))
            ->setCategories($categories)
            ->setDescription($data['description'])
            ->setId((int) $data['id'])
            ->setName($data['name'])
            ->setPrice($jsonToMoney($data['price']))
            ->setTaxable($sqlToBool($data['taxable']));
    }

    private function hydrateCategories(array $data): array
    {
        $hydrate = (new HydrateCategory());
        $categories = [];
        foreach ($data['categories'] as $category) {
            $categories[] = $hydrate($category);
        }

        return $categories;
    }
}
