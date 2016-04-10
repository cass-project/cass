<?php

use Phinx\Migration\AbstractMigration;

class ProfileInitMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('profile')
            ->addColumn('is_initialized', 'boolean', ['default' => 0])
        ->save();
    }
}
