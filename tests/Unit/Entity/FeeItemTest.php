<?php

use IamPersistent\SimpleShop\Entity\FeeItem;
use Money\Money;

describe('FeeItem', function () {
    it('calculate the fee amount', function (
        string $feePercent,
        
        ?Money $amount = null,
        Money $subTotal,
        Money $expectedAmount,
    ) {
        $feeItem = new \IamPersistent\SimpleShop\Entity\FeeItem($feePercent, $amount);
        $feeItem->calculate($subTotal);

        expect($feeItem->getAmount())->toEqual($expectedAmount);
    })->with('feeItemCalculateData');
});
