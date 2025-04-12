<?php

use Phinx\Migration\AbstractMigration;

class CreateInvoiceTable extends AbstractMigration
{
    public function change()
    {
        $this->table('invoices')
            ->addColumn('currency', 'char', ['limit' => 3])
            ->addColumn('entrant_id', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('header', 'string')
            ->addColumn('invoice_date', 'date')
            ->addColumn('invoice_number', 'string', ['limit' => 100])
            ->addColumn('paid_id', 'integer', ['signed' => false, 'null' => true])
            ->addForeignKey('paid_id', 'invoice_paid', 'id')
            ->addColumn('recipient_id', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('subtotal', 'text')
            ->addColumn('tax_rate', 'float')
            ->addColumn('taxes', 'text')
            ->addColumn('total', 'text')
            ->create();
    }
}
