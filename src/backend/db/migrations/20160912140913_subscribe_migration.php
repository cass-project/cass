<?php

use Phinx\Migration\AbstractMigration;

class SubscribeMigration extends AbstractMigration
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
    public function change()
    {
        $this->table('subscribe')
            ->addColumn('profile_id', 'integer', [ 'null' => false ])
            ->addColumn('subscribe_id', 'integer', [ 'null' => false ])
            ->addColumn('type', 'integer', [ 'null' => false ])
            ->addColumn('options', 'text',['null' => true])
            ->addForeignKey('profile_id', 'profile', 'id', [
                'delete' => 'cascade',
                'update' => 'cascade'
            ])
            ->create()
        ;
    }
}
