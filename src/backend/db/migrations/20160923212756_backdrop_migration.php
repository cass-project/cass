<?php

use Phinx\Migration\AbstractMigration;

class BackdropMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('profile')
            ->addColumn('backdrop', 'text')
            ->save();

        $this->table('collections')
            ->addColumn('backdrop', 'text')
            ->save();

        $this->table('communities')
            ->addColumn('backdrop', 'text')
            ->save();
    }
}
