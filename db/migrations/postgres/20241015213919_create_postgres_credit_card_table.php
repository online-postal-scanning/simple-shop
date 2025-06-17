<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreatePostgresCreditCardTable extends AbstractMigration
{
    public function up(): void
    {
        $this->table('credit_cards')
            ->addColumn('brand', 'string', ['null' => true])
            ->addColumn('card_number', 'string', ['limit' => 19])
            ->addColumn('card_reference', 'string')
            ->addColumn('city', 'string', ['null' => true])
            ->addColumn('country', 'string', ['null' => true])
            ->addColumn('expiration_date', 'date')
            ->addColumn('is_active', 'boolean', ['default' => true])
            ->addColumn('last_four', 'string', ['limit' => 4])
            ->addColumn('name_on_card', 'string', ['null' => true])
            ->addColumn('owner_id', 'string')
            ->addColumn('post_code', 'string', ['null' => true])
            ->addColumn('state', 'string', ['null' => true])
            ->addColumn('street_1', 'string', ['null' => true])
            ->addColumn('street_2', 'string', ['null' => true])
            ->addColumn('title', 'string', ['null' => true])
            ->addColumn('security_code', 'string', ['limit' => 255])
            ->addColumn('type', 'string', ['limit' => 255])
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
            CREATE TRIGGER update_credit_cards_timestamp
            BEFORE UPDATE ON credit_cards
            FOR EACH ROW
            EXECUTE FUNCTION {$schema}.update_timestamp();
        ");
    }

    public function down(): void
    {
        $this->table('credit_cards')->drop()->save();
    }
}
