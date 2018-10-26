<?php
declare(strict_types=1);

namespace Tests\Unit\Interactor;

use IamPersistent\SimpleShop\Interactor\JsonToMoney;
use Money\Currency;
use Money\Money;
use UnitTester;

class JsonToMoneyCest
{
    public function testInvoke(UnitTester $I)
    {
        $startingMoney = new Money(1000, new Currency('USD'));
        $json = json_encode($startingMoney);

        $money = (new JsonToMoney)($json);

        $I->assertEquals($startingMoney, $money);
    }
}
