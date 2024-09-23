<?php
declare(strict_types=1);

namespace Tests\Unit\Interactor;

use IamPersistent\SimpleShop\Entity\Invoice;
use IamPersistent\SimpleShop\Entity\InvoiceItem;
use IamPersistent\SimpleShop\Interactor\TotalInvoice;
use Money\Currency;
use Money\Money;
use UnitTester;

class TotalInvoiceCest
{
    /** @var TotalInvoice */
    private $totalInvoice;

    public function __construct()
    {
        $this->totalInvoice = (new TotalInvoice());
    }

    public function testHandle(UnitTester $I)
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

        $I->assertEquals(Money::USD(10430), $invoice->getSubtotal());
        $I->assertEquals(Money::USD(28), $invoice->getTaxes());
        $I->assertEquals(Money::USD(10458), $invoice->getTotal());
    }
}
