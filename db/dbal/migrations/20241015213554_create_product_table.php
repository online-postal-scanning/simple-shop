<?php

declare(strict_types=1);

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class CreateProductTable extends AbstractMigration
{
    public function change(): void
    {
        $this->table('products')
            ->addColumn('active', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'signed' => false])
            ->addColumn('description', 'string')
            ->addColumn('name', 'string')
            ->addColumn('price', 'text')
            ->addColumn('taxable', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'signed' => false])
            ->addTimestamps()
            ->create();
    }
}
