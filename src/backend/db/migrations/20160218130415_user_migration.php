<?php

use Phinx\Migration\AbstractMigration;

class UserMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('account')
            ->addColumn('email', 'string')
            ->addColumn('password', 'string')
            ->addColumn('token', 'string', ['null' => true])
            ->addColumn('tokenExpired', 'integer', ['null' => true])
            ->addIndex(['email'], ['unique' => true])
            ->create()
        ;

        $this->table('oauth_account')
            ->addColumn('account_id', 'integer')
            ->addForeignKey('account_id', 'account', 'id', ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION'])
            ->addColumn('token', 'string')
            ->addColumn('expires', 'timestamp')
            ->addColumn('provider_name', 'string')
            ->create()
        ;
    }
}
