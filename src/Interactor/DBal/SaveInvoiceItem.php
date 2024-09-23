<?php
declare(strict_types=1);

namespace OLPS\SimpleShop\Interactor\DBal;

use OLPS\SimpleShop\Entity\Invoice;
use OLPS\SimpleShop\Entity\InvoiceItem;
use OLPS\SimpleShop\Interactor\ObjectHasId;

final class SaveInvoiceItem extends DBalCommon
{
    public function save(Invoice $invoice, InvoiceItem $invoiceItem): bool
    {
        if ($invoiceItem->getId()) {
            return $this->updateData($invoice, $invoiceItem);
        }

        return $this->insertData($invoice, $invoiceItem);
    }

    private function insertData(Invoice $invoice, InvoiceItem $invoiceItem): bool
    {
        $data = $this->prepDataForPersistence($invoice, $invoiceItem);

        $response = $this->connection->insert('invoice_items', $data);
        if (1 === $response) {
            $id = $this->connection->lastInsertId();
            $invoiceItem->setId($id);

            return true;
        } else {
            return false;
        }
    }

    private function updateData(Invoice $invoice, InvoiceItem $invoiceItem): bool
    {
        $data = $this->prepDataForPersistence($invoice, $invoiceItem);

        $response = $this->connection->update('invoice_items', $data, ['id' => $invoiceItem->getId()]);

        return true;
    }

    private function prepDataForPersistence(Invoice $invoice, InvoiceItem $invoiceItem): array
    {
        if ($product = $invoiceItem->getProduct()) {
            $productId = $product->getId();
        } else {
            $productId = null;
        }

        return [
            'amount' => json_encode($invoiceItem->getAmount()),
            'description' => $invoiceItem->getDescription(),
            'invoice_id' => $invoice->getId(),
            'is_taxable' => $invoiceItem->isTaxable() ? 1 : 0,
            'product_id' => $productId,
            'quantity' => $invoiceItem->getQuantity(),
            'total_amount' => json_encode($invoiceItem->getTotalAmount()),
        ];
    }
}
