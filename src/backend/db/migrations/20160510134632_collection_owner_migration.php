<?php

use Phinx\Migration\AbstractMigration;

class CollectionOwnerMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('community')
            ->addColumn('collections', 'text')
        ->save();

        $this->table('profile')
            ->addColumn('collections', 'text')
        ->save();
    }
}
