<?php

use Phinx\Migration\AbstractMigration;

class CollectionReduceMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('collection')
            ->dropForeignKey('parent_id')
            ->dropForeignKey('profile_id')
            ->removeColumn('parent_id')
            ->removeColumn('profile_id')
            ->removeColumn('position')
        ->save();
    }
}
