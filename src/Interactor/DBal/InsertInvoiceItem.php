<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Interactor\DBal;

use IamPersistent\SimpleShop\Entity\Invoice;
use IamPersistent\SimpleShop\Entity\InvoiceItem;

final class InsertInvoiceItem extends DBalCommon
{
    public function insert(Invoice $invoice, InvoiceItem $invoiceItem)
    {
        $data = [
            'amount' => json_encode($invoiceItem->getAmount()),
            'description' => $invoiceItem->getDescription(),
            'invoice_id' => $invoice->getId(),
            'is_taxable' => $invoiceItem->isTaxable() ? 1 : 0,
            'quantity' => $invoiceItem->getQuantity(),
            'total_amount' => json_encode($invoiceItem->getTotalAmount()),
        ];
        $response = $this->connection->insert('invoice_items', $data);
        if (1 === $response) {
            $id = $this->connection->lastInsertId();
            $invoiceItem->setId($id);

            return;
        }
    }
}