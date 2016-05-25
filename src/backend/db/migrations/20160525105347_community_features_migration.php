<?php

use Phinx\Migration\AbstractMigration;

class CommunityFeaturesMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('community')
            ->addColumn('features', 'text')
        ->save();
    }
}
