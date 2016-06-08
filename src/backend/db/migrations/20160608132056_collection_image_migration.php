<?php

use Phinx\Migration\AbstractMigration;

class CollectionImageMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('collection')
             ->addColumn('image', 'text',['null' => true])
             ->save();

    }
}
