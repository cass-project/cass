<?php

use Phinx\Migration\AbstractMigration;

class ProfileCommunitiesMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('profile_communities')
            ->addColumn('profile_id', 'integer')
            ->addColumn('community_id', 'integer')
            ->addForeignKey('profile_id', 'profile', 'id', [
                'update' => 'cascade',
                'delete' => 'cascade'
            ])
            ->addForeignKey('community_id', 'community', 'id', [
                'update' => 'cascade',
                'delete' => 'cascade'
            ])
        ->create();
    }
}
