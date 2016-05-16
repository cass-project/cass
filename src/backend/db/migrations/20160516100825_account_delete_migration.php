<?php

use Phinx\Migration\AbstractMigration;

class AccountDeleteMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('account')
            ->addColumn('is_account_delete_requested', 'boolean', [
                'default' => false
            ])
            ->addColumn('date_account_delete_request', 'datetime', [
                'null' => true
            ])
        ->save();
    }
}
