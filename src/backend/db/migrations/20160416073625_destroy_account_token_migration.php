<?php

use Phinx\Migration\AbstractMigration;

class DestroyAccountTokenMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('account')
            ->removeColumn('token')
            ->removeColumn('tokenExpired')
        ->save();
    }
}
