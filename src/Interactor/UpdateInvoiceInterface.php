<?php
declare(strict_types=1);

namespace OLPS\SimpleShop\Interactor;

use OLPS\SimpleShop\Entity\Invoice;

interface UpdateInvoiceInterface
{
    public function update(Invoice $invoice): bool;
}
