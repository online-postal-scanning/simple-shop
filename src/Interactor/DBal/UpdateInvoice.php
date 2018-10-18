<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Interactor\DBal;

use IamPersistent\SimpleShop\Entity\Invoice;
use IamPersistent\SimpleShop\Interactor\UpdateInvoiceInterface;

final class UpdateInvoice extends DBalCommon implements UpdateInvoiceInterface
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