<?php

use Phinx\Migration\AbstractMigration;

class CommunityMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('community')
            ->addColumn('date_created_on', 'datetime')
            ->addColumn('title', 'string')
            ->addColumn('description', 'text')
            ->addColumn('theme_id', 'integer', ['null'=> TRUE])
            ->addColumn('image', 'text')
            ->addForeignKey('theme_id', 'theme', 'id', [
                'update' => 'cascade',
                'delete' => 'restrict'
            ])
        ->create();
    }
}
