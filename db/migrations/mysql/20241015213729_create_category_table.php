<?php

use Phinx\Migration\AbstractMigration;

class CreateCategoryTable extends AbstractMigration
{
    public function change()
    {
        $this->table('categories')
            ->addColumn('name', 'string', ['limit' => 255])
            ->addTimestamps()
            ->create();
    }
}
