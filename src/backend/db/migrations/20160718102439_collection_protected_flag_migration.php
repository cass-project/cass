<?php

use Phinx\Migration\AbstractMigration;

class CollectionProtectedFlagMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('collection')
            ->addColumn('is_protected', 'boolean')
        ->save();
    }
}
