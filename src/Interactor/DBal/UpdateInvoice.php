<?php
declare(strict_types=1);

namespace OLPS\SimpleShop\Interactor\DBal;

use OLPS\SimpleShop\Entity\Invoice;
use OLPS\SimpleShop\Interactor\UpdateInvoiceInterface;

final class UpdateInvoice extends AbstractInvoice implements UpdateInvoiceInterface
{
    public function update(Invoice $invoice): bool
    {
        $sql = $this->sql($invoice);
        $statement = $this->connection->executeQuery($sql);


    }

    private function sql(Invoice $invoice): string
    {

    }
}
