<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreatePostgresInvoiceTable extends AbstractMigration
{
    public function up(): void
    {
        $this->table('invoices')
            ->addColumn('currency', 'string', ['limit' => 3])
            ->addColumn('entrant_id', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('header', 'string')
            ->addColumn('invoice_date', 'date')
            ->addColumn('invoice_number', 'string', ['limit' => 100])
            ->addColumn('paid_id', 'integer', ['null' => true])
            ->addColumn('recipient_id', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('subtotal', 'jsonb', ['null' => false])
            ->addColumn('tax_rate', 'decimal', ['precision' => 10, 'scale' => 4])
            ->addColumn('taxes', 'jsonb', ['null' => false])
            ->addColumn('total', 'jsonb', ['null' => false])
            ->addTimestamps()
            ->addForeignKey('paid_id', 'invoice_paid', 'id')
            ->create();

        $this->execute("
            ALTER TABLE invoices
            ADD CONSTRAINT subtotal_format_check
            CHECK (
                subtotal ? 'amount' AND
                subtotal ? 'currency' AND
                jsonb_typeof(subtotal->'amount') = 'number' AND
                jsonb_typeof(subtotal->'currency') = 'string'
            )
        ");

        $this->execute("
            ALTER TABLE invoices
            ADD CONSTRAINT total_format_check
            CHECK (
                total ? 'amount' AND
                total ? 'currency' AND
                jsonb_typeof(total->'amount') = 'number' AND
                jsonb_typeof(total->'currency') = 'string'
            )
        ");

        $this->execute("
            ALTER TABLE invoices
            ADD CONSTRAINT taxes_format_check
            CHECK (
                taxes ? 'amount' AND
                taxes ? 'currency' AND
                jsonb_typeof(taxes->'amount') = 'number' AND
                jsonb_typeof(taxes->'currency') = 'string'
            )
        ");

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

    public function down(): void
    {
        $this->table('invoices')->drop()->save();
    }
}
