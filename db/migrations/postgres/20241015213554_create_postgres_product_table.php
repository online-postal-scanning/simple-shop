<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreatePostgresProductTable extends AbstractMigration
{
    public function change(): void
    {
        $this->table('products')
            ->addColumn('active', 'boolean', ['default' => false])
            ->addColumn('description', 'string')
            ->addColumn('name', 'string')
            ->addColumn('price', 'text')
            ->addColumn('taxable', 'boolean', ['default' => false])
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
            CREATE TRIGGER update_products_timestamp
            BEFORE UPDATE ON products
            FOR EACH ROW
            EXECUTE FUNCTION {$schema}.update_timestamp();
        ");
    }
}