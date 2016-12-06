<?php

use Phinx\Migration\AbstractMigration;

class PostLikesMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('post')
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
