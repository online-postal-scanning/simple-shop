<?php

namespace Tests\Unit\OLPS\SimpleShop\Entity;

use OLPS\SimpleShop\Entity\FeeItem;
use Money\Money;
use PHPUnit\Framework\TestCase;

class FeeItemTest extends TestCase
{
    public function testCalculateFeeAmount()
    {
        $feeItemCalculateData = $this->feeItemCalculateDataProvider();

        foreach ($feeItemCalculateData as $testCase) {
            [$feePercent, $amount, $subTotal, $expectedAmount] = $testCase;

            $feeItem = new FeeItem($feePercent, $amount);
            $feeItem->calculate($subTotal);

            $this->assertEquals($expectedAmount, $feeItem->getAmount());
        }
    }

    public function feeItemCalculateDataProvider()
    {
        $currency = new \Money\Currency('USD');
        return [
            ['0.04', null, new Money(12585, $currency), new Money(503, $currency)],
            ['0.04', new Money(299, $currency), new Money(7615, $currency), new Money(604, $currency)],
            ['0.035', new Money(99, $currency), new Money(34218, $currency), new Money(1297, $currency)],
        ];
    }
}
