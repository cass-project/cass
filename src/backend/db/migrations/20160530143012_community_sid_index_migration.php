<?php

use Phinx\Migration\AbstractMigration;

class CommunitySidIndexMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('community')
            ->addIndex('sid')
        ->save();
    }
}
