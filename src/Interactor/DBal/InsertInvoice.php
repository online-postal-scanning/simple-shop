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
        $paid = $invoice->getPaid();
        $data = [
            'authorization_code' => $paid->getAuthorizationCode(),
            'date'               => $paid->getDate()->format('m-d-Y'),
            'card_id'            => $paid->getCard()->getId(),
        ];
        $response = $this->connection->insert('paid', $data);
        if (1 !== $response) {
            return;
        }
        $paidId = $this->connection->lastInsertId();
        $paid->setId($paidId);

        $data = [
            'invoice_date' => $invoice->getInvoiceDate()->format('m-d-Y'),
            'invoice_number' => $invoice->getInvoiceNumber(),
            'paid_id' => $paidId,
            'subtotal' => json_encode($invoice->getSubtotal()),
            'tax_rate' => $invoice->getTaxRate(),
            'taxes' => json_encode($invoice->getTaxes()),
            'total' => json_encode($invoice->getTotal()),
        ];
        $response = $this->connection->insert('invoices', $data);
        if (1 !== $response) {
            return;
        }
        $id = $this->connection->lastInsertId();
        $invoice->setId($id);
    }
}