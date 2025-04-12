<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreatePostgresCheckTable extends AbstractMigration
{
    public function change(): void
    {
        $this->table('checks')
            ->addColumn('check_number', 'string', ['limit' => 255])
            ->addColumn('date', 'date', ['null' => true])
            ->create();
    }
}