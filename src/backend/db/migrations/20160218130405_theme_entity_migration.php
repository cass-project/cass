<?php

use Phinx\Migration\AbstractMigration;

class ThemeEntityMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('theme')
            ->addColumn('parent_id', 'integer', [
                'null' => true
            ])
            ->addColumn('title', 'string')
            ->addForeignKey('parent_id', 'theme', 'id', [
                'delete' => 'cascade',
                'update' => 'cascade'
            ])
            ->create()
        ;
    }
}
