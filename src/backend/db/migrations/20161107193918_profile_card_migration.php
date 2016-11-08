<?php

use Phinx\Migration\AbstractMigration;

class ProfileCardMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('profile')
            ->addColumn('profile_card', 'text')
            ->save();
    }
}
