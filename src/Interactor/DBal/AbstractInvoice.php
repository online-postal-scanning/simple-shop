<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Interactor\DBal;

use Doctrine\DBAL\Connection;
use IamPersistent\SimpleShop\Interactor\TotalInvoice;

abstract class AbstractInvoice extends DBalCommon
{
    /** @var InsertInvoiceItem */
    protected $insertItem;
    /** @var TotalInvoice */
    protected $totalInvoice;
    /** @var UpdateInvoiceItem */
    protected $updateItem;

    public function __construct(Connection $connection)
    {
        parent::__construct($connection);
        $this->totalInvoice = new TotalInvoice();
        $this->insertItem = new InsertInvoiceItem($connection);
        $this->updateItem = new UpdateInvoiceItem($connection);
    }
}