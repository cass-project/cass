<?php

use Phinx\Migration\AbstractMigration;

class Profile extends AbstractMigration
{
    public function change()
    {
        $this->table('profile')
            ->addColumn('account_id', 'integer')
            ->addForeignKey('account_id', 'account', 'id', [
                'delete' => 'cascade',
                'update' => 'cascade'
            ])
            ->create()
        ;
    }
}
