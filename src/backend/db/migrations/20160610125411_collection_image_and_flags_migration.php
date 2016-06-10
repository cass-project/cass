<?php

use Phinx\Migration\AbstractMigration;

class CollectionImageAndFlagsMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('collection')
            ->addColumn('author_profile_id', 'integer')
            ->addColumn('image', 'text')
            ->addColumn('is_private', 'boolean', [
                'default' => false
            ])
            ->addColumn('public_enabled', 'boolean', [
                'default' => true
            ])
            ->addColumn('moderation_contract', 'boolean', [
                'default' => false
            ])
            ->addForeignKey('author_profile_id', 'profile', 'id', [
                'update' => 'cascade',
                'delete' => 'cascade'
            ])
        ->save();
    }
}
