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
            ->create();
    }
}