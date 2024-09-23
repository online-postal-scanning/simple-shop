<?php
declare(strict_types=1);

namespace OLPS\SimpleShop\Interactor;

use OLPS\SimpleShop\Entity\Invoice;

interface SaveInvoiceInterface
{
    public function save(Invoice $invoice): bool;
}
