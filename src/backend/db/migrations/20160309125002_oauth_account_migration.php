<?php

use Phinx\Migration\AbstractMigration;

class OauthAccountMigration extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('oauth_account');
        $table->drop();

        $table = $this->table('oauth_account');
        $table
            ->addColumn('account_id', 'integer')
            ->addColumn('provider', 'string')
            ->addColumn('provider_account_id', 'string')
            ->addForeignKey('account_id', 'account', 'id', [
                'delete' => 'cascade',
                'update' => 'cascade'
            ])
            ->create()
        ;
    }
}
