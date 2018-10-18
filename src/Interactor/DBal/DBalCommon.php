<?php
declare(strict_types=1);

namespace IamPersistent\SimpleShop\Interactor\DBal;

use Doctrine\DBAL\Connection;

abstract class DBalCommon
{
    protected $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }
}