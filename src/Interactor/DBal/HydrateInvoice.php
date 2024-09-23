<?php
declare(strict_types=1);

namespace OLPS\SimpleShop\Interactor\DBal;

use DateTime;
use IamPersistent\Money\Interactor\JsonToMoney;
use OLPS\SimpleShop\Entity\Invoice;
use OLPS\SimpleShop\Entity\InvoiceItem;
use Money\Currency;

final class HydrateInvoice
{
    public function __invoke(array $data): Invoice
    {
        $invoiceDate = (new DateTime($data['invoice_date']));
        $jsonToMoney = new JsonToMoney();
        $paidData = $data;
        $paidData['id'] = $data['paid_id'];
        $paid = (new HydratePaid())($paidData);

        $subtotal = $jsonToMoney($data['subtotal']);
        $taxes = $jsonToMoney($data['taxes']);
        $total = $jsonToMoney($data['total']);

        $items = [];
        foreach ($data['items'] as $itemData) {
            $items[] = $this->hydrateItem($itemData);
        }

        return (new Invoice())
            ->setCurrency(new Currency($data['currency']))
            ->setEntrantId($data['entrant_id'])
            ->setHeader($data['header'])
            ->setId($data['id'])
            ->setInvoiceNumber($data['invoice_number'])
            ->setInvoiceDate($invoiceDate)
            ->setItems($items)
            ->setPaid($paid)
            ->setRecipientId($data['recipient_id'])
            ->setSubtotal($subtotal)
            ->setTaxes($taxes)
            ->setTaxRate((string) $data['tax_rate'])
            ->setTotal($total);
    }

    private function hydrateItem(array $data): InvoiceItem
    {
        $jsonToMoney = new JsonToMoney();
        $amount = $jsonToMoney($data['amount']);
        $totalAmount = $jsonToMoney($data['total_amount']);

        $item = (new InvoiceItem())
            ->setAmount($amount)
            ->setDescription($data['description'])
            ->setId($data['id'])
            ->setIsTaxable((bool) $data['is_taxable'])
            ->setQuantity((int) $data['quantity'])
            ->setTotalAmount($totalAmount);

        if (!empty($data['product']['id'])) {
            $product = (new HydrateProduct)($data['product']);
            $item->setProduct($product);
        }

        return $item;
    }
}
