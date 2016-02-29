<?php

use Phinx\Migration\AbstractMigration;

class ThemeHostForeignKeyMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('theme')
            ->addColumn('host_id', 'integer')
            ->addForeignKey('host_id', 'host', 'id', [
                'delete' => 'cascade',
                'update' => 'cascade'
            ])
            ->update()
        ;
    }
}
