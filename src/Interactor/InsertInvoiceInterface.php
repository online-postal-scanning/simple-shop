<?php
declare(strict_types=1);

namespace OLPS\SimpleShop\Interactor;

use OLPS\SimpleShop\Entity\Invoice;

interface InsertInvoiceInterface
{
    public function insert(Invoice $invoice): bool;
}
