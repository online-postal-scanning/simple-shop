<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Interactor\DBal;

use Doctrine\DBAL\Connection;
use IamPersistent\SimpleShop\Entity\Invoice;
use IamPersistent\SimpleShop\Interactor\SaveInvoiceInterface;

final class SaveInvoice implements SaveInvoiceInterface
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;

    }

    public function save(Invoice $invoice): bool
    {

    }
}