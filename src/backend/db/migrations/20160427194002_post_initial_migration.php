<?php

use Phinx\Migration\AbstractMigration;

class PostInitialMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('post')
            ->addColumn('author_profile_id', 'integer')
            ->addColumn('collection_id', 'integer')
            ->addColumn('date_created_on', 'datetime')
            ->addColumn('content', 'text')
            ->addForeignKey('author_profile_id', 'profile', 'id', [
                'delete' => 'cascade',
                'update' => 'cascade'
            ])
            ->addForeignKey('collection_id', 'collection', 'id', [
                'delete' => 'cascade',
                'update' => 'cascade'
            ])
        ->create();
    }
}
