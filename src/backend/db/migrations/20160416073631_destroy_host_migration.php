<?php

use Phinx\Migration\AbstractMigration;

class DestroyHostMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('theme')
            ->dropForeignKey('host_id')
            ->removeColumn('host_id')
            ->save();

        $this->table('host')->drop();
    }
}
