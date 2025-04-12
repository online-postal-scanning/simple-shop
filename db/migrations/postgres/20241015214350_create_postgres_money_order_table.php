<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreatePostgresMoneyOrderTable extends AbstractMigration
{
    public function change(): void
    {
        $this->table('money_orders')
            ->addColumn('serial_number', 'string', ['limit' => 255])
            ->addColumn('date', 'date', ['null' => true])
            ->create();
    }
}