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
            ->addTimestamps()
            ->create();

        $schema = $this->getAdapter()->getOption('schema');
        $this->execute("
            CREATE OR REPLACE FUNCTION {$schema}.update_timestamp()
            RETURNS TRIGGER AS $$
            BEGIN
                NEW.updated_at = CURRENT_TIMESTAMP;
                RETURN NEW;
            END;
            $$ language 'plpgsql';
        ");

        $this->execute("
            CREATE TRIGGER update_invoice_items_timestamp
            BEFORE UPDATE ON invoice_items
            FOR EACH ROW
            EXECUTE FUNCTION {$schema}.update_timestamp();
        ");
    }
}