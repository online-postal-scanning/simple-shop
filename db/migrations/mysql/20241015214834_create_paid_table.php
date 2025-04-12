<?php

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class CreatePaidTable extends AbstractMigration
{
    public function change()
    {
        $this->table('invoice_paid')
            ->addColumn('amount', 'text')
            ->addColumn('authorization_code', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('date', 'date')
            ->addColumn('payment_method_id', 'integer', ['signed' => false, 'null' => false])
            ->addColumn('payment_method_type', 'string', ['limit' => 255])
            ->create();
   }
}
