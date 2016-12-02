<?php

use Phinx\Migration\AbstractMigration;

class ProfileLikesMigration extends AbstractMigration
{

    public function change()
    {
        $this->table('profile')
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
