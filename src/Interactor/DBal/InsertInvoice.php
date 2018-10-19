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

        $sql = $this->sql($invoice);

        $items = $invoice->getItems();
        foreach ($items as $item) {
            $this->insertItem->insert($invoice, $item);
        }

        return true;
    }

    private function sql(Invoice $invoice): string
    {
        $sql = '';

        return $sql;
    }
}