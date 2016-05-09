<?php

use Phinx\Migration\AbstractMigration;

class ProfileGenderMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('profile')
            ->addColumn('gender', 'integer', ['null' => true ])
        ->save();
    }
}
