<?php

use Phinx\Migration\AbstractMigration;

class AnonymousMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('account')
            ->addColumn('is_anonymous', 'boolean', [
                'default' => false
            ])
            ->save()
        ;

        $this->table('account')->insert([
            ['email' => 'anonymous@cass.io', 'is_anonymous' => true]
        ])->saveData();
    }
}
