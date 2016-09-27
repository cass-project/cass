<?php

use Phinx\Migration\AbstractMigration;

class BackdropMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('profile')
            ->addColumn('backdrop', 'text')
            ->save();

        $this->table('collection')
            ->addColumn('backdrop', 'text')
            ->save();

        $this->table('community')
            ->addColumn('backdrop', 'text')
            ->save();
    }
}
