<?php

use Phinx\Migration\AbstractMigration;

class AccountEmailVerificationFlagsMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('account')
            ->addColumn('is_disabled', 'boolean', ['default' => false])
            ->addColumn('disabled_reason', 'string', ['null' => true])
            ->addColumn('is_email_verified', 'boolean', ['default' => false])
        ->save();
    }
}
