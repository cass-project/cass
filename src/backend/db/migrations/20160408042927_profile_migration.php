<?php

use Phinx\Migration\AbstractMigration;

class ProfileMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('profile')
            ->addColumn('account_id', 'integer')
            ->addColumn('is_current', 'boolean')
        ->create();

        $this->table('profile_greetings')
            ->addColumn('profile_id', 'integer', ['null' => false])
            ->addColumn('greetings_method', 'string', ['null' => false])
            ->addColumn('first_name', 'string', ['null' => true])
            ->addColumn('last_name', 'string', ['null' => true])
            ->addColumn('middle_name', 'string', ['null' => true])
            ->addColumn('nick_name', 'string', ['null' => true])
            ->addForeignKey('profile_id', 'profile', 'id', [
                'delete' => 'cascade',
                'update' => 'cascade'
            ])
            ->create();

        $this->table('profile_image')
            ->addColumn('profile_id', 'integer', ['null' => false])
            ->addColumn('storage_path', 'string', ['null' => false])
            ->addColumn('public_path', 'string', ['null' => false])
            ->addForeignKey('profile_id', 'profile', 'id', [
                'delete' => 'cascade',
                'update' => 'cascade'
            ])
            ->create();

        $this->table('profile')
            ->addForeignKey('account_id', 'account', 'id', [
                'delete' => 'cascade',
                'update' => 'cascade'
            ])
        ->save();
    }
}
