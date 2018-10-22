<?php


use Phinx\Migration\AbstractMigration;

class CreditCard extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    addCustomColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Any other destructive changes will result in an error when trying to
     * rollback the migration.
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $this->table('credit_cards')
            ->addColumn('card_number', 'string', ['limit' => 19])
            ->addColumn('card_reference', 'string')
            ->addColumn('expiration_date', 'date')
            ->addColumn('last_four', 'string', ['limit' => 4])
            ->addColumn('owner_id', 'integer')
            ->addColumn('title', 'string')
            ->create();
    }
}
