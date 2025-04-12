<?php

use Phinx\Migration\AbstractMigration;

class CreateMoneyOrderTable extends AbstractMigration
{
    public function change()
    {
        $this->table('money_orders')
            ->addColumn('serial_number', 'string', ['limit' => 255])
            ->addColumn('date', 'date', ['null' => true])
            ->create();
    }
}
