<?php

use Phinx\Migration\AbstractMigration;

class CollectionDateCreatedOnMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('collection')
            ->addColumn('date_created_on', 'datetime')
            ->save();
    }
}
