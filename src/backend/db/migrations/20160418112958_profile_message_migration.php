<?php

use Phinx\Migration\AbstractMigration;

class ProfileMessageMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('profile_message')
            ->addColumn('source_profile_id', 'integer')
            ->addColumn('target_profile_id', 'integer')
            ->addColumn('date_created', 'datetime')
            ->addColumn('date_read', 'datetime', ['null' => true])
            ->addColumn('is_read', 'boolean')
            ->addColumn('content', 'text')
            ->addForeignKey('source_profile_id', 'profile', 'id', [
                'delete' => 'cascade',
                'update' => 'cascade'
            ])
            ->addForeignKey('target_profile_id', 'profile', 'id', [
                'delete' => 'cascade',
                'update' => 'cascade'
            ])
        ->create();
    }
}
