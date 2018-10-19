<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Interactor;

use IamPersistent\SimpleShop\Entity\Invoice;

interface InsertInvoiceInterface
{
    public function insert(Invoice $invoice): bool;
}