<?php

use Phinx\Migration\AbstractMigration;

class ProfileSidMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('profile')
            ->addColumn('sid', 'string', ['length' => 12])
        ->save();
    }
}
