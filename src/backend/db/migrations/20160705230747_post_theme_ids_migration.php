<?php

use Phinx\Migration\AbstractMigration;

class PostThemeIdsMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('post_theme_ids')
            ->addColumn('theme_id', 'integer')
            ->addColumn('post_id', 'integer')
            ->addForeignKey('theme_id', 'theme', 'id', [
                'update' => 'cascade',
                'delete' => 'cascade'
            ])
            ->addForeignKey('post_id', 'post', 'id', [
                'update' => 'cascade',
                'delete' => 'cascade'
            ])
        ->create();

        $this->table('post')
            ->addColumn('theme_ids', 'string')
        ->save();
    }
}
