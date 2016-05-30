<?php

use Phinx\Migration\AbstractMigration;

class CommunityMetadataMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('community')
            ->addColumn('metadata', 'text')
        ->save();
    }
}
