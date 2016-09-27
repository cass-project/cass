<?php

use Phinx\Migration\AbstractMigration;

class SubscribeMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('subscribe')
            ->addColumn('profile_id', 'integer', [ 'null' => false ])
            ->addColumn('subscribe_id', 'integer', [ 'null' => false ])
            ->addColumn('type', 'integer', [ 'null' => false ])
            ->addColumn('options', 'text',['null' => true])
            ->addForeignKey('profile_id', 'profile', 'id', [
                'delete' => 'cascade',
                'update' => 'cascade'
            ])
            ->create()
        ;
    }
}
