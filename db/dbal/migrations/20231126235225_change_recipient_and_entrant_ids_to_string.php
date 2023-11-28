<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class ChangeRecipientAndEntrantIdsToString extends AbstractMigration
{
    public function change(): void
    {
        $this->table('invoices')
            ->changeColumn('entrant_id', 'string', ['limit' => 255, 'null' => true])
            ->changeColumn('recipient_id', 'string', ['limit' => 255, 'null' => false])
            ->update();
    }
}
