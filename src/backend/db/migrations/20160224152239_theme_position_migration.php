<?php

use Phinx\Migration\AbstractMigration;

class ThemePositionMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('theme')
            ->addColumn('position', 'integer')
            ->update()
        ;
    }
}
