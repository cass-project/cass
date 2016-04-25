<?php

use Phinx\Migration\AbstractMigration;

class InterestingInMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('profile_interesting_in')
            ->addColumn('profile_id', 'integer')
            ->addColumn('theme_id', 'integer')
            ->addForeignKey('profile_id', 'profile', 'id', [
                'delete' => 'cascade',
                'update' => 'cascade'
            ])
            ->addForeignKey('theme_id', 'theme', 'id', [
                'delete' => 'cascade',
                'update' => 'cascade'
            ])
        ->create();

        $this->table('profile')
            ->addColumn('interesting_in_str', 'text')
            ->save()
        ;
    }
}
