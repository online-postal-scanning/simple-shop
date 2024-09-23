<?php
declare(strict_types=1);

namespace OLPS\SimpleShop\Interactor\DBal;

use OLPS\SimpleShop\Entity\Invoice;
use OLPS\SimpleShop\Interactor\InsertInvoiceInterface;

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
            'amount'              => json_encode($paid->getAmount()),
            'authorization_code'  => $paid->getAuthorizationCode(),
            'date'                => $paid->getDate()->format('Y-m-d'),
            'payment_method_id'   => $paid->getPaymentMethod()->getId(),
            'payment_method_type' => $paid->getPaymentMethod()->getPaymentMethodType(),
        ];
        $response = $this->connection->insert('invoice_paid', $data);
        if (1 !== $response) {
            return;
        }
        $paidId = $this->connection->lastInsertId();
        $paid->setId($paidId);
        $data = [
            'currency'       => $invoice->getCurrency()->getCode(),
            'header'         => $invoice->getHeader(),
            'invoice_date'   => $invoice->getInvoiceDate()->format('Y-m-d'),
            'invoice_number' => $invoice->getInvoiceNumber(),
            'recipient_id'   => $invoice->getRecipientId(),
            'paid_id'        => $paidId,
            'subtotal'       => json_encode($invoice->getSubtotal()),
            'tax_rate'       => $invoice->getTaxRate(),
            'taxes'          => json_encode($invoice->getTaxes()),
            'total'          => json_encode($invoice->getTotal()),
        ];
        $response = $this->connection->insert('invoices', $data);
        if (1 !== $response) {
            return;
        }
        $id = $this->connection->lastInsertId();
        $invoice->setId($id);
    }
}
