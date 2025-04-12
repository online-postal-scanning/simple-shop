<?php

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class CreateCreditCardTable extends AbstractMigration
{
    public function change()
    {
        $this->table('credit_cards')
            ->addColumn('brand', 'string', ['null' => true])
            ->addColumn('card_number', 'string', ['limit' => 19])
            ->addColumn('card_reference', 'string')
            ->addColumn('city', 'char', ['null' => true])
            ->addColumn('country', 'char', ['null' => true])
            ->addColumn('expiration_date', 'date')
            ->addColumn('is_active', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'signed' => false, 'default' => 1])
            ->addColumn('last_four', 'string', ['limit' => 4])
            ->addColumn('name_on_card', 'char', ['null' => true])
            ->addColumn('owner_id', 'string')
            ->addColumn('post_code', 'char', ['null' => true])
            ->addColumn('state', 'char', ['null' => true])
            ->addColumn('street_1', 'char', ['null' => true])
            ->addColumn('street_2', 'char', ['null' => true])
            ->addColumn('title', 'string', ['null' => true])
            ->addColumn('security_code', 'string', ['limit' => 255])
            ->addColumn('type', 'string', ['limit' => 255])
            ->addTimestamps()
            ->create();
    }
}
