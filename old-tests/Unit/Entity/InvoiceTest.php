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

    describe('addItem', function() {
        it('adds an item', function() {
            $invoice = (new Invoice())
                ->setCurrency(new Currency('USD'))
                ->setTaxRate(.065);
            $item = (new InvoiceItem())
                ->setIsTaxable(true)
                ->setAmount(Money::USD(430));
            $invoice->addItem($item);

            expect($invoice->getItems())->toHaveCount(1);
            expect($invoice->getItems()[0])->toEqual($item);
        });
        it('calls calculate', function() {
            $invoice = (new Invoice())
                ->setCurrency(new Currency('USD'))
                ->setTaxRate(.065);
            $item = (new InvoiceItem())
                ->setIsTaxable(true)
                ->setAmount(Money::USD(430));
            $invoice->addItem($item);

            expect($invoice->getSubtotal())->toEqual(Money::USD(430));
            expect($invoice->getTaxes())->toEqual(Money::USD(28));
            expect($invoice->getTotal())->toEqual(Money::USD(458));
        });
    });

    describe('setItems', function() {
        it ('sets items', function() {
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

            expect($invoice->getItems())->toHaveCount(2);
            expect($invoice->getItems()[1])->toEqual($itemB);
        });
    });
});
