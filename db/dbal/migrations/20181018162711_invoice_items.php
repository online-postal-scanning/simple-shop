<?php

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class InvoiceItems extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    addCustomColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Any other destructive changes will result in an error when trying to
     * rollback the migration.
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $this->table('invoice_items')
            ->addColumn('amount', 'text')
            ->addColumn('description', 'string', ['limit' => 255])
            ->addColumn('invoice_id', 'integer', ['signed' => false, 'null' => false])
            ->addColumn('is_taxable', 'boolean', ['null' => false, 'signed' => false, 'default' => 0])
            ->addColumn('quantity', 'integer', ['null' => true, 'signed' => false, 'limit' => MysqlAdapter::INT_SMALL])
            ->addColumn('total_amount', 'text')
            ->create();
   }
}
