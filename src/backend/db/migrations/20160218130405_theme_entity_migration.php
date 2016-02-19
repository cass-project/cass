<?php

use Phinx\Migration\AbstractMigration;

class ThemeEntityMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('theme')
            ->addColumn('parent_id', 'integer')
            ->addColumn('title', 'string')
            ->addForeignKey('parent_id', 'theme', 'id')
        ;
    }
}
