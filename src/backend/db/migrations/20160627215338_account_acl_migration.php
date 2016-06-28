<?php

use Phinx\Migration\AbstractMigration;

class AccountAclMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('account_app_access')
            ->addColumn('account_id', 'integer')
            ->addColumn('app_admin', 'boolean')
            ->addColumn('app_reports', 'boolean')
            ->addColumn('app_feedback', 'boolean')
            ->addForeignKey('account_id', 'account', 'id', [
                'update' => 'cascade',
                'delete' => 'cascade'
            ])
            ->create()
        ;
    }
}
