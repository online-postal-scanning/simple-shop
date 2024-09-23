<?php
declare(strict_types=1);

namespace OLPS\SimpleShop\Interactor\DBal;

use Doctrine\DBAL\Connection;

abstract class DBalCommon
{
    /** @var Connection */
    protected $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }
}
