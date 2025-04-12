<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreatePostgresInvoiceTable extends AbstractMigration
{
    public function change(): void
    {
        $this->table('invoices')
            ->addColumn('currency', 'string', ['limit' => 3])
            ->addColumn('entrant_id', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('header', 'string')
            ->addColumn('invoice_date', 'date')
            ->addColumn('invoice_number', 'string', ['limit' => 100])
            ->addColumn('paid_id', 'integer', ['null' => true])
            ->addForeignKey('paid_id', 'invoice_paid', 'id')
            ->addColumn('recipient_id', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('subtotal', 'text')
            ->addColumn('tax_rate', 'decimal', ['precision' => 10, 'scale' => 4])
            ->addColumn('taxes', 'text')
            ->addColumn('total', 'text')
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
            CREATE TRIGGER update_invoices_timestamp
            BEFORE UPDATE ON invoices
            FOR EACH ROW
            EXECUTE FUNCTION {$schema}.update_timestamp();
        ");
    }
}