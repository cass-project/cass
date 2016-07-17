<?php

use Phinx\Migration\AbstractMigration;

class ProfileDateCreatedOnMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('profile')
            ->addColumn('date_created_on', 'datetime')
        ->save();
    }
}
