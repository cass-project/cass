<?php

use Phinx\Migration\AbstractMigration;

class Profile extends AbstractMigration
{
    public function change()
    {
        $this->table('profile')
            ->addColumn('account_id', 'integer')
            ->addColumn('is_current', 'boolean')
            ->addColumn('profile_greetings_id', 'integer', ['null' => false])
            ->addColumn('profile_image_id', 'integer', ['null' => false])
        ->create();

        $this->table('profile_greetings')
            ->addColumn('profile_id', 'integer', ['null' => false])
            ->addColumn('greetings_method', 'string', ['null' => false])
            ->addColumn('first_name', 'string')
            ->addColumn('last_name', 'string')
            ->addColumn('nick_name', 'string')
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
            ->addForeignKey('profile_greetings_id', 'profile_greetings', 'id', [
                'delete' => 'cascade',
                'update' => 'cascade'
            ])
            ->addForeignKey('profile_image_id', 'profile_image', 'id', [
                'delete' => 'cascade',
                'update' => 'cascade'
            ])
        ->save();
    }
}
