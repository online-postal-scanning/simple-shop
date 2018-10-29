<?php
declare(strict_types=1);

namespace Tests\Functional\Interactor\DBal;

use DateTime;
use Doctrine\DBAL\Connection;
use IamPersistent\SimpleShop\Entity\CreditCard;
use IamPersistent\SimpleShop\Entity\Invoice;
use IamPersistent\SimpleShop\Entity\InvoiceItem;
use IamPersistent\SimpleShop\Entity\Paid;
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
        $card = (new CreditCard())
            ->setId(1);
        $paid = (new Paid())
            ->setAmount(Money::USD(2910))
            ->setAuthorizationCode('8675309')
            ->setCard($card)
            ->setDate(new DateTime('2018-10-19'));
        $invoice = (new Invoice())
            ->setCurrency(new Currency('USD'))
            ->setHeader('Monthly Subscription')
            ->setInvoiceDate(new DateTime('2018-10-19'))
            ->setInvoiceNumber('42')
            ->setItems($items)
            ->setRecipientId('256')
            ->setPaid($paid)
            ->setTaxRate(.065);
        $this->insertInvoice->insert($invoice);
        $invoiceData = $this->connection->fetchAll('SELECT * FROM invoices');
        $invoiceItemsData = $this->connection->fetchAll('SELECT * FROM invoice_items');
        $paidData = $this->connection->fetchAll('SELECT * FROM invoice_paid');
        $I->assertEquals($this->expectedInvoiceData(), $invoiceData);
        $I->assertEquals($this->expectedInvoiceItemsData(), $invoiceItemsData);
        $I->assertEquals($this->expectedPaidData(), $paidData);
    }

    private function expectedInvoiceData(): array
    {
        return [
            [
                'header'         => 'Monthly Subscription',
                'invoice_date'   => '2018-10-19',
                'invoice_number' => '42',
                'id'             => '1',
                'paid_id'        => '1',
                'recipient_id'       => '256',
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

    private function expectedPaidData(): array
    {
        return [
            [
                'amount'             => '{"amount":"2910","currency":"USD"}',
                'authorization_code' => '8675309',
                'date'               => '2018-10-19',
                'card_id'            => '1',
                'id'                 => '1',
            ],
        ];
    }
}
