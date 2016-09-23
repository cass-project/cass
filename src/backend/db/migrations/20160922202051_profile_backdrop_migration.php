<?php

use Phinx\Migration\AbstractMigration;

class ProfileBackdropMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('profile')
            ->addColumn('backdrop', 'string', [
                'default' => '/storage/entity/profile/defaults/default-backdrop.jpg'
            ])
            ->save();
    }
}
