<?php

use Phinx\Migration\AbstractMigration;

class CommunityLikesMigration extends AbstractMigration
{

    public function change()
    {
        $this->table('community')
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
