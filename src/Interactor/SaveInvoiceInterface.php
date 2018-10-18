<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Interactor;

use IamPersistent\SimpleShop\Entity\Invoice;

interface SaveInvoiceInterface
{
    public function save(Invoice $invoice): bool;
}