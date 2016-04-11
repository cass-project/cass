<?php

use Phinx\Migration\AbstractMigration;

class CollectionThemeMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('collection')
            ->addColumn('theme_id', 'integer', ['null' => true])
            ->addForeignKey('theme_id', 'theme', 'id', [
                'delete' => 'cascade',
                'update' => 'cascade'
            ])
        ->save();
    }
}
