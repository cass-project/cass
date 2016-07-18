<?php

use Phinx\Migration\AbstractMigration;

class CommunityOwnerMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('community')
            ->addColumn('owner_id', 'integer')
            ->addForeignKey('owner_id', 'account', 'id', [
                'update' => 'cascade',
                'delete' => 'restrict' // !
            ])
        ->save();
    }
}
