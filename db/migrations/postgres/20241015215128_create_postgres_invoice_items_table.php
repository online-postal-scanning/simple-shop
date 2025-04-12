<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreatePostgresInvoiceItemsTable extends AbstractMigration
{
    public function change(): void
    {
        $this->table('invoice_items')
            ->addColumn('amount', 'text')
            ->addColumn('description', 'string', ['limit' => 255])
            ->addColumn('invoice_id', 'integer', ['null' => false])
            ->addForeignKey('invoice_id', 'invoices', 'id')
            ->addColumn('is_taxable', 'boolean', ['null' => false, 'default' => false])
            ->addColumn('product_id', 'integer', ['null' => true])
            ->addForeignKey('product_id', 'products', 'id')
            ->addColumn('quantity', 'smallinteger', ['null' => true])
            ->addColumn('total_amount', 'text')
            ->create();
    }
}