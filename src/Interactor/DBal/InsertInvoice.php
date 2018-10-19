<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Interactor\DBal;

use IamPersistent\SimpleShop\Entity\Invoice;
use IamPersistent\SimpleShop\Interactor\InsertInvoiceInterface;

final class InsertInvoice extends AbstractInvoice implements InsertInvoiceInterface
{
    public function insert(Invoice $invoice): bool
    {
        $this->totalInvoice->handle($invoice); // critical so we don't save the wrong values

        $this->persist($invoice);

        $items = $invoice->getItems();
        foreach ($items as $item) {
            $this->insertItem->insert($invoice, $item);
        }

        return true;
    }

    private function persist(Invoice $invoice)
    {
        $data = [
            'invoice_date' => $invoice->getInvoiceDate()->format('m-d-Y'),
            'invoice_number' => $invoice->getInvoiceNumber(),
            'subtotal' => json_encode($invoice->getSubtotal()),
            'tax_rate' => $invoice->getTaxRate(),
            'taxes' => json_encode($invoice->getTaxes()),
            'total' => json_encode($invoice->getTotal()),
        ];
        $response = $this->connection->insert('invoices', $data);
        if (1 === $response) {
            $id = $this->connection->lastInsertId();
            $invoice->setId($id);
        } else {

        }
    }
}