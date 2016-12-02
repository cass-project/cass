<?php

use Phinx\Migration\AbstractMigration;

class CollectionLikesMigration extends AbstractMigration
{

    public function change()
    {
        $this->table('collection')
            ->addColumn('likes', 'integer', [
                'default' => 0,
                'null' => TRUE
            ])
            ->addColumn('dislikes', 'integer', [
                'default' => 0,
                'null' => TRUE,
            ])
            ->save();
    }
}
