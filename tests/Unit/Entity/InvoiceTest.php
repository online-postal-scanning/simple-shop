<?php

namespace Tests\Unit\OLPS\SimpleShop\Entity;

use Money\Currency;
use Money\Money;
use OLPS\SimpleShop\Entity\Invoice;
use OLPS\SimpleShop\Entity\InvoiceItem;
use PHPUnit\Framework\TestCase;

class InvoiceTest extends TestCase
{
    public function testCalculate()
    {
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
        $this->assertEquals(Money::USD(10430), $invoice->getSubtotal());
        $this->assertEquals(Money::USD(28), $invoice->getTaxes());
        $this->assertEquals(Money::USD(10458), $invoice->getTotal());
    }

    public function testAddItem()
    {
        $invoice = (new Invoice())
            ->setCurrency(new Currency('USD'))
            ->setTaxRate(.065);
        $item = (new InvoiceItem())
            ->setIsTaxable(true)
            ->setAmount(Money::USD(430));
        $invoice->addItem($item);
        $this->assertCount(1, $invoice->getItems());
        $this->assertEquals($item, $invoice->getItems()[0]);
        $this->assertEquals(Money::USD(430), $invoice->getSubtotal());
        $this->assertEquals(Money::USD(28), $invoice->getTaxes());
        $this->assertEquals(Money::USD(458), $invoice->getTotal());
    }

    public function testSetItems()
    {
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
        $this->assertCount(2, $invoice->getItems());
        $this->assertEquals($itemB, $invoice->getItems()[1]);
    }
}
