<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Interactor;

use Money\Currency;
use Money\Money;

final class JsonToMoney
{
    public function __invoke(string $json): Money
    {
        $data = json_decode($json, true);

        return new Money($data['amount'], new Currency($data['currency']));
    }
}