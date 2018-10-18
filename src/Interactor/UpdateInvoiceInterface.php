<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Interactor;

use IamPersistent\SimpleShop\Entity\Invoice;

interface UpdateInvoiceInterface
{
    public function update(Invoice $invoice): bool;
}