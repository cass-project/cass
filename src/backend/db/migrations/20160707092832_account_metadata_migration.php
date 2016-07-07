<?php

use Phinx\Migration\AbstractMigration;

class AccountMetadataMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('account')
            ->addColumn('metadata', 'text')
        ->save();
    }
}
