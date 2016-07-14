<?php

use Phinx\Migration\AbstractMigration;

class ContactMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('contact')
            ->addColumn('sid', 'string', [
                'null' => false
            ])
            ->addColumn('date_created_on', 'datetime', [
                'null' => false
            ])
            ->addColumn('date_permanent_on', 'datetime', [
                'null' => true
            ])
            ->addColumn('source_profile_id', 'integer', [
                'null' => false
            ])
            ->addColumn('target_profile_id', 'integer', [
                'null' => false
            ])
            ->addForeignKey('source_profile_id', 'profile', 'id', [
                'update' => 'cascade',
                'delete' => 'cascade'
            ])
            ->addForeignKey('target_profile_id', 'profile', 'id', [
                'update' => 'cascade',
                'delete' => 'cascade'
            ])
        ->create();
    }
}
