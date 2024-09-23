<?php
declare(strict_types=1);

namespace OLPS\SimpleShop\Interactor;

use OLPS\SimpleShop\Entity\Invoice;
use OLPS\SimpleShop\Entity\InvoiceItem;
use Money\Money;

final class TotalInvoice
{
    public function handle(Invoice $invoice)
    {
        $this->sumInvoiceItems($invoice);
        $this->calculateTax($invoice);
        $this->calculateTotal($invoice);
    }

    private function calculateItem(InvoiceItem $item)
    {
        $quantity = $item->getQuantity() ?? 1;
        $totalAmount = $item->getAmount()->multiply($quantity);
        $item->setTotalAmount($totalAmount);
    }

    private function calculateTax(Invoice $invoice)
    {
        $taxableTotal = new Money(0, $invoice->getCurrency());
        foreach ($invoice->getItems() as $item) {
            if ($item->isTaxable()) {
                $taxableTotal = $taxableTotal->add($item->getTotalAmount());
            }
        }
        $taxes = $taxableTotal->multiply($invoice->getTaxRate());
        $invoice->setTaxes($taxes);
    }

    private function calculateTotal(Invoice $invoice)
    {
        $total = $invoice->getSubtotal();
        $total = $total->add($invoice->getTaxes());
        $invoice->setTotal($total);
    }

    private function sumInvoiceItems(Invoice $invoice)
    {
        $sum = new Money(0, $invoice->getCurrency());
        foreach ($invoice->getItems() as $item) {
            $this->calculateItem($item);
            $sum = $sum->add($item->getTotalAmount());
        }
        $invoice->setSubtotal($sum);
    }
}
