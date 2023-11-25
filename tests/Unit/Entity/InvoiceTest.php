<?php

use IamPersistent\SimpleShop\Entity\Invoice;
use IamPersistent\SimpleShop\Entity\InvoiceItem;
use Money\Currency;
use Money\Money;

describe('Invoice', function() {
    test('calculate', function() {
        $invoice = (new Invoice())
            ->setCurrency(new Currency('USD'))
            ->setTaxRate(.065);
        $itemA = (new InvoiceItem())
            ->setIsTaxable(false)
            ->setAmount(Money::USD(10000));
        $itemB = (new InvoiceItem())
            ->setIsTaxable(true)
            ->setAmount(Money::USD(430));
        $invoice->setItems([$itemA, $itemB]);

        $invoice->calculate();

        expect($invoice->getSubtotal())->toEqual(Money::USD(10430));
        expect($invoice->getTaxes())->toEqual(Money::USD(28));
        expect($invoice->getTotal())->toEqual(Money::USD(10458));
    });
});
