<?php

use Phinx\Migration\AbstractMigration;

class ProfileBirthdayMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('profile')
            ->addColumn('birthday', 'datetime', [
                'null' => true
            ])
        ->save();
    }
}
