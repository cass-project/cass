<?php
use Phinx\Migration\AbstractMigration;

class EqCollectionThemeCommunityMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('collection_theme_ids')
            ->addColumn('theme_id', 'integer')
            ->addColumn('collection_id', 'integer')
            ->addForeignKey('theme_id', 'theme', 'id', [
                'update' => 'cascade',
                'delete' => 'cascade'
            ])
            ->addForeignKey('collection_id', 'collection', 'id', [
                'update' => 'cascade',
                'delete' => 'cascade'
            ])
            ->create();

        $this->table('community_theme_ids')
            ->addColumn('theme_id', 'integer')
            ->addColumn('community_id', 'integer')
            ->addForeignKey('theme_id', 'theme', 'id', [
                'update' => 'cascade',
                'delete' => 'cascade'
            ])
            ->addForeignKey('community_id', 'community', 'id', [
                'update' => 'cascade',
                'delete' => 'cascade'
            ])
            ->create();

        $this->table('profile_expert_in_theme_ids')
            ->addColumn('theme_id', 'integer')
            ->addColumn('profile_id', 'integer')
            ->addForeignKey('theme_id', 'theme', 'id', [
                'update' => 'cascade',
                'delete' => 'cascade'
            ])
            ->addForeignKey('profile_id', 'profile', 'id', [
                'update' => 'cascade',
                'delete' => 'cascade'
            ])
            ->create();

        $this->table('profile_interesting_in_theme_ids')
            ->addColumn('theme_id', 'integer')
            ->addColumn('profile_id', 'integer')
            ->addForeignKey('theme_id', 'theme', 'id', [
                'update' => 'cascade',
                'delete' => 'cascade'
            ])
            ->addForeignKey('profile_id', 'profile', 'id', [
                'update' => 'cascade',
                'delete' => 'cascade'
            ])
            ->create();

        $this->table('community_collection_ids')
            ->addColumn('community_id', 'integer')
            ->addColumn('collection_id', 'integer')
            ->addForeignKey('collection_id', 'collection', 'id', [
                'update' => 'cascade',
                'delete' => 'cascade'
            ])
            ->addForeignKey('community_id', 'community', 'id', [
                'update' => 'cascade',
                'delete' => 'cascade'
            ])
            ->create();

        $this->table('profile_collection_ids')
            ->addColumn('profile_id', 'integer')
            ->addColumn('collection_id', 'integer')
            ->addForeignKey('collection_id', 'collection', 'id', [
                'update' => 'cascade',
                'delete' => 'cascade'
            ])
            ->addForeignKey('profile_id', 'profile', 'id', [
                'update' => 'cascade',
                'delete' => 'cascade'
            ])
            ->create();
    }
}
