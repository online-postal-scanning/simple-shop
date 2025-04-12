<?php

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class CreateInvoiceItemsTable extends AbstractMigration
{
    public function change()
    {
        $this->table('invoice_items')
            ->addColumn('amount', 'text')
            ->addColumn('description', 'string', ['limit' => 255])
            ->addColumn('invoice_id', 'integer', ['signed' => false, 'null' => false])
            ->addForeignKey('invoice_id', 'invoices', 'id')
            ->addColumn('is_taxable', 'boolean', ['null' => false, 'signed' => false, 'default' => 0])
            ->addColumn('product_id', 'integer', ['signed' => false, 'null' => true])
            ->addForeignKey('product_id', 'products', 'id')
            ->addColumn('quantity', 'integer', ['null' => true, 'signed' => false, 'limit' => MysqlAdapter::INT_SMALL])
            ->addColumn('total_amount', 'text')
            ->addTimestamps()
            ->create();
   }
}
