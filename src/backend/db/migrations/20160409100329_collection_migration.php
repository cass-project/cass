<?php

use Phinx\Migration\AbstractMigration;

class CollectionMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('collection')
            ->addColumn('profile_id', 'integer')
            ->addColumn('title', 'string')
            ->addColumn('description', 'text')
            ->addColumn('parent_id', 'integer', ['null' => true])
            ->addColumn('position', 'integer')
            ->addForeignKey('profile_id', 'profile', 'id', [
                'delete' => 'cascade',
                'update' => 'cascade'
            ])
            ->addForeignKey('parent_id', 'collection', 'id', [
                'delete' => 'cascade',
                'update' => 'cascade'
            ])
        ->create();
    }
}
