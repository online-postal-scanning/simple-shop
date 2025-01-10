<?php
declare(strict_types=1);

namespace Tests\Integration\Interactor\DBal;

use DateTime;
use Money\Currency;
use Money\Money;
use OLPS\SimpleShop\Entity\CreditCard;
use OLPS\SimpleShop\Entity\Invoice;
use OLPS\SimpleShop\Entity\InvoiceItem;
use OLPS\SimpleShop\Entity\Paid;
use OLPS\SimpleShop\Interactor\DBal\InsertInvoice;
use Tests\Integration\IntegrationTestCase;

class InsertInvoiceTest extends IntegrationTestCase
{
    private InsertInvoice $insertInvoice;

    protected function setUp(): void
    {
        parent::setUp();

        $this->insertInvoice = new InsertInvoice(self::$connection);
    }

    public function testInsert(): void
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
            ->setPaymentMethod($card)
            ->setDate(new DateTime('2018-10-19'));

        $invoice = (new Invoice())
            ->setCurrency(new Currency('USD'))
            ->setHeader('Monthly Subscription')
            ->setInvoiceDate(new DateTime('2018-10-19'))
            ->setInvoiceNumber('42')
            ->setItems($items)
            ->setRecipientId(256)
            ->setPaid($paid)
            ->setTaxRate(.065);

        $this->insertInvoice->insert($invoice);

        $invoiceData = self::$connection->fetchAllAssociative('SELECT * FROM invoices');
        $invoiceItemsData = self::$connection->fetchAllAssociative('SELECT * FROM invoice_items');
        $paidData = self::$connection->fetchAllAssociative('SELECT * FROM invoice_paid');

        $this->assertEquals($this->expectedInvoiceData(), $invoiceData);
        $this->assertEquals($this->expectedInvoiceItemsData(), $invoiceItemsData);
        $this->assertEquals($this->expectedPaidData(), $paidData);
    }

    private function expectedInvoiceData(): array
    {
        return [
            [
                'currency'       => 'USD',
                'entrant_id'     => null,
                'header'         => 'Monthly Subscription',
                'invoice_date'   => '2018-10-19',
                'invoice_number' => '42',
                'id'             => 1,
                'paid_id'        => 1,
                'recipient_id'   => '256',
                'subtotal'       => '{"amount":"2748","currency":"USD"}',
                'taxes'          => '{"amount":"162","currency":"USD"}',
                'total'          => '{"amount":"2910","currency":"USD"}',
                'tax_rate'       => 0.065,
            ],
        ];
    }

    private function expectedInvoiceItemsData(): array
    {
        return [
            [
                'id'           => 1,
                'amount'       => '{"amount":"2499","currency":"USD"}',
                'description'  => "Monthly subscription",
                'invoice_id'   => 1,
                'is_taxable'   => 1,
                'product_id'   => null,
                'quantity'     => null,
                'total_amount' => '{"amount":"2499","currency":"USD"}',
            ],
            [
                'id'           => 2,
                'amount'       => '{"amount":"249","currency":"USD"}',
                'description'  => "Service Fee",
                'invoice_id'   => 1,
                'is_taxable'   => 0,
                'product_id'   => null,
                'quantity'     => null,
                'total_amount' => '{"amount":"249","currency":"USD"}',
            ],
        ];
    }

    private function expectedPaidData(): array
    {
        return [
            [
                'amount'              => '{"amount":"2910","currency":"USD"}',
                'authorization_code'  => '8675309',
                'date'                => '2018-10-19',
                'id'                  => 1,
                'payment_method_id'  => 1,
                'payment_method_type' => 'creditCard',
            ],
        ];
    }
}
