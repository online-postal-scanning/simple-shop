<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreatePostgresCategoryTable extends AbstractMigration
{
    public function up(): void
    {
        $this->table('categories')
            ->addColumn('name', 'string', ['limit' => 255])
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
            CREATE TRIGGER update_categories_timestamp
            BEFORE UPDATE ON categories
            FOR EACH ROW
            EXECUTE FUNCTION {$schema}.update_timestamp();
        ");
    }

    public function down(): void
    {
        $this->table('categories')->drop()->save();
    }
}
