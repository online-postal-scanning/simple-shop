<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Interactor;

use IamPersistent\SimpleShop\Entity\Invoice;

final class FetchInvoiceInterface
{
    public function fetch($id): ?Invoice
    {

    }
}