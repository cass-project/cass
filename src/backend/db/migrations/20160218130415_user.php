<?php

use Phinx\Migration\AbstractMigration;

class User extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    private $accountTableName = 'account';
    private $oauthAccountTableName = 'oauth_account';


    public function change()
    {
        // Adding account table
        $this->table($this->accountTableName)
            ->addColumn('email', 'string')
            ->addColumn('phone', 'integer', ['null' => true])
            ->addColumn('password', 'string')
            ->addColumn('token', 'string', ['null' => true])
            ->addColumn('tokenExpired', 'integer', ['null' => true])
            ->addIndex(['phone'], ['unique' => true])
            ->addIndex(['email'], ['unique' => true])
            ->create()
        ;

        // Adding aouth account table
        $this->table($this->oauthAccountTableName)
            ->addColumn('account_id', 'integer')
            ->addForeignKey('account_id', $this->accountTableName, 'id', ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION'])
            ->addColumn('token', 'string')
            ->addColumn('expires', 'timestamp')
            ->addColumn('provider_name', 'string')
            ->create()
        ;

        $this->insertData();
    }

    private function insertData(){
        $this->table($this->accountTableName)->insert([
            ['email' => 'artem.baydin@cass.io',             'password' => password_hash("Lolipop1234", PASSWORD_DEFAULT)],
            ['email' => 'vyacheslav.savushkin@cass.io',     'password' => password_hash("1234", PASSWORD_DEFAULT)],
            ['email' => 'dmitriy.borisenko.baydin@cass.io', 'password' => password_hash("1234", PASSWORD_DEFAULT)],
            ['email' => 'philip.mantrov@cass.io',           'password' => password_hash("1234", PASSWORD_DEFAULT)]
        ])->saveData();
    }
}
