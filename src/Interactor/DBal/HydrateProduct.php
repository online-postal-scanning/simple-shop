<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Interactor\DBal;

use AMB\Interactor\Db\SQLToBool;
use IamPersistent\Money\Interactor\JsonToMoney;
use IamPersistent\SimpleShop\Entity\Product;

final class HydrateProduct
{
    public function __invoke($data): Product
    {
        $sqlToBool = (new SQLToBool());
        $jsonToMoney = (new JsonToMoney());

        return (new Product())
            ->setActive($sqlToBool($data['active']))
            ->setDescription($data['description'])
            ->setName($data['name'])
            ->setPrice($jsonToMoney($data['price']))
            ->setTaxable($sqlToBool($data['taxable']));
    }
}
