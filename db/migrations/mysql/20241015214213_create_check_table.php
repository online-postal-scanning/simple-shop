<?php

use Phinx\Migration\AbstractMigration;

class CreateCheckTable extends AbstractMigration
{
    public function change()
    {
        $this->table('checks')
            ->addColumn('check_number', 'string', ['limit' => 255])
            ->addColumn('routing_number', 'string', ['limit' => 255])
            ->addColumn('date', 'date', ['null' => true])
            ->addTimestamps()
            ->create();
    }
}
