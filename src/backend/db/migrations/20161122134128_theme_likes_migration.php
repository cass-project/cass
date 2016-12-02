<?php

use Phinx\Migration\AbstractMigration;

class ThemeLikesMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('theme')
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
