<?php
declare(strict_types=1);

namespace Tests\Functional\Interactor\DBal;

use DateTime;
use Doctrine\DBAL\Connection;
use IamPersistent\SimpleShop\Entity\Invoice;
use IamPersistent\SimpleShop\Entity\InvoiceItem;
use IamPersistent\SimpleShop\Interactor\DBal\InsertInvoice;
use FunctionalTester;
use Money\Currency;
use Money\Money;

class InsertInvoiceCest
{
    /** @var Connection */
    private $connection;
    /** @var InsertInvoice */
    private $insertInvoice;

    public function _before(FunctionalTester $I)
    {
        $this->connection = $I->getDBalConnection();
        $I->setUpDatabase();
        $this->insertInvoice = new InsertInvoice($this->connection);
    }

    public function testInsert(FunctionalTester $I)
    {
        $items = [];
        $items[] = (new InvoiceItem())
            ->setAmount(Money::USD(2499))
            ->setDescription('Monthly subscription')
            ->setIsTaxable(true);
        $items[] = (new InvoiceItem())
            ->setAmount(Money::USD(249))
            ->setDescription('Service Fee')
            ->setIsTaxable(false);
        $invoice = (new Invoice())
            ->setCurrency(new Currency('USD'))
            ->setInvoiceDate(new DateTime('2018-10-19'))
            ->setInvoiceNumber('42')
            ->setItems($items)
            ->setTaxRate(.065);
        $this->insertInvoice->insert($invoice);
        $invoiceData = $this->connection->fetchAll('SELECT * FROM invoices');
        $invoiceItemsData = $this->connection->fetchAll('SELECT * FROM invoice_items');
        $I->assertEquals($this->expectedInvoiceData(), $invoiceData);
        $I->assertSame($this->expectedInvoiceItemsData(), $invoiceItemsData);
    }

    private function expectedInvoiceData(): array
    {
        return [
            [
                'invoice_date'   => '10-19-2018',
                'invoice_number' => '42',
                'id'             => '1',
                'subtotal'       => '{"amount":"2748","currency":"USD"}',
                'taxes'          => '{"amount":"162","currency":"USD"}',
                'total'          => '{"amount":"2910","currency":"USD"}',
                'tax_rate'       => '0.065',
            ],
        ];
    }

    private function expectedInvoiceItemsData(): array
    {
        return [
            [
                'id'           => '1',
                'amount'       => '{"amount":"2499","currency":"USD"}',
                'description'  => "Monthly subscription",
                'invoice_id'   => '1',
                'is_taxable'   => '1',
                'quantity'     => null,
                'total_amount' => '{"amount":"2499","currency":"USD"}',
            ],
            [
                'id'           => '2',
                'amount'       => '{"amount":"249","currency":"USD"}',
                'description'  => "Service Fee",
                'invoice_id'   => '1',
                'is_taxable'   => '0',
                'quantity'     => null,
                'total_amount' => '{"amount":"249","currency":"USD"}',
            ],
        ];
    }
}
