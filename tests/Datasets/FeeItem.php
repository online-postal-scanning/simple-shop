<?php

use Money\Currency;
use Money\Money;

$currency = new Currency('USD');
dataset('feeItemCalculateData', [
    'no base fee' =>
        ['.04', null, new Money(12585, $currency), new Money(503, $currency),],
    'with base fee' =>
        ['.04', new Money(299, $currency), new Money(7615, $currency), new Money(604, $currency),],
    'different set of values' =>
        ['.035', new Money(99, $currency), new Money(34218, $currency), new Money(1297, $currency),],
]);
