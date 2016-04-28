<?php

use Phinx\Migration\AbstractMigration;

class EmailVerificationMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('email_verification')
            ->addColumn('for_account_id', 'integer')
            ->addColumn('date_requested', 'datetime')
            ->addColumn('token', 'string')
            ->addColumn('is_confirmed', 'boolean')
            ->addColumn('date_confirmed', 'datetime', ['null' => true])
            ->addForeignKey('for_account_id', 'account', 'id', [
                'delete' => 'cascade',
                'update' => 'cascade'
            ])
        ->create();
    }
}
