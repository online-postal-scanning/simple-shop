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
            ->create();
    }
}