<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreatePostgresMoneyOrderTable extends AbstractMigration
{
    public function change(): void
    {
        $this->table('money_orders')
            ->addColumn('serial_number', 'string', ['limit' => 255])
            ->addColumn('date', 'date', ['null' => true])
            ->addColumn('check_number', 'string', ['limit' => 255])
            ->addColumn('routing_number', 'string', ['limit' => 255])
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
            CREATE TRIGGER update_money_orders_timestamp
            BEFORE UPDATE ON money_orders
            FOR EACH ROW
            EXECUTE FUNCTION {$schema}.update_timestamp();
        ");
    }
}