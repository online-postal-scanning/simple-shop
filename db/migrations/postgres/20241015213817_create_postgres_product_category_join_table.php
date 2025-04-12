<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreatePostgresProductCategoryJoinTable extends AbstractMigration
{
    public function change(): void
    {
        $this->table('product_categories')
            ->addColumn('category_id', 'integer', ['null' => false])
            ->addForeignKey('category_id', 'categories', 'id')
            ->addColumn('product_id', 'integer', ['null' => false])
            ->addForeignKey('product_id', 'products', 'id')
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
            CREATE TRIGGER update_product_categories_timestamp
            BEFORE UPDATE ON product_categories
            FOR EACH ROW
            EXECUTE FUNCTION {$schema}.update_timestamp();
        ");
    }
}