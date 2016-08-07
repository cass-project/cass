<?php

use Phinx\Migration\AbstractMigration;

class AccountKeyMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('account')
            ->addColumn('api_key', 'string', [
                'null' => false
            ])
            ->addColumn('sid', 'string', [
                'null' => false
            ])
        ->save();

    }
}
