<?php

use Phinx\Migration\AbstractMigration;

class CollectionOwnerIdMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('collection')
            ->addColumn('owner_sid', 'string')
        ->save();
    }
}
