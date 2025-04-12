<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreatePostgresProductTable extends AbstractMigration
{
    public function change(): void
    {
        $this->table('products')
            ->addColumn('active', 'boolean', ['default' => false])
            ->addColumn('description', 'string')
            ->addColumn('name', 'string')
            ->addColumn('price', 'text')
            ->addColumn('taxable', 'boolean', ['default' => false])
            ->addTimestamps()
            ->create();
    }
}