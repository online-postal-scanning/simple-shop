<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreatePostgresCreditCardTable extends AbstractMigration
{
    public function change(): void
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
            ->create();
    }
}