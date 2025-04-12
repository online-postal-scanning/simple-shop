<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreatePostgresPaidTable extends AbstractMigration
{
    public function change(): void
    {
        $this->table('invoice_paid')
            ->addColumn('amount', 'text')
            ->addColumn('authorization_code', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('date', 'date')
            ->addColumn('payment_method_id', 'integer', ['null' => false])
            ->addColumn('payment_method_type', 'string', ['limit' => 255])
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
            CREATE TRIGGER update_invoice_paid_timestamp
            BEFORE UPDATE ON invoice_paid
            FOR EACH ROW
            EXECUTE FUNCTION {$schema}.update_timestamp();
        ");
    }
}