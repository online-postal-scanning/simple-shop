<?php


use Phinx\Migration\AbstractMigration;

class ChangeCreditCardToPaymentMethodInPaid extends AbstractMigration
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
        $this->table('invoice_paid')
            ->addColumn('payment_method_type', 'string', ['limit' => 255])
            ->renameColumn('card_id', 'payment_method_id')
            ->update();
        $this->table('invoice_paid')
            ->changeColumn('authorization_code', 'string', ['limit' => 255, 'null' => true])
            ->changeColumn('payment_method_id', 'integer', ['signed' => false, 'null' => true])
            ->update();
    }
}
