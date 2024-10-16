<?php
declare(strict_types=1);

namespace Tests\Unit\OLPS\SimpleShop\Interactor;

use OLPS\SimpleShop\Entity\Invoice;
use OLPS\SimpleShop\Entity\InvoiceItem;
use OLPS\SimpleShop\Interactor\TotalInvoice;
use Money\Currency;
use Money\Money;
use PHPUnit\Framework\TestCase;

class TotalInvoiceTest extends TestCase
{
    private TotalInvoice $totalInvoice;

    protected function setUp(): void
    {
        $this->totalInvoice = new TotalInvoice();
    }

    public function testHandle()
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

        $this->totalInvoice->handle($invoice);

        $this->assertEquals(Money::USD(10430), $invoice->getSubtotal());
        $this->assertEquals(Money::USD(28), $invoice->getTaxes());
        $this->assertEquals(Money::USD(10458), $invoice->getTotal());
    }
}
