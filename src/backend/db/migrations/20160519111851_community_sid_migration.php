<?php

use Phinx\Migration\AbstractMigration;

class CommunitySidMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('community')
            ->addColumn('sid', 'string')
        ->save();

        $this->table('profile_communities')
            ->addColumn('community_sid', 'string')
        ->save();
    }
}
