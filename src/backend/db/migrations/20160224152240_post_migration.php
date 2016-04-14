<?php

use Phinx\Migration\AbstractMigration;

class PostMigration extends AbstractMigration
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
        $this->table('post')
             ->addColumn('account_id', 'integer', [
               'null' => true
             ])
             ->addColumn('title', 'string',['null' => true])
             ->addColumn('description', 'text',['null' => true])
             ->addColumn('created', 'datetime',['null' => true])
             ->addColumn('updated', 'datetime',['null' => true])
             ->addColumn('is_published', 'boolean',['default'=> 0])
             ->addForeignKey('account_id', 'account', 'id', [
               'delete' => 'cascade',
               'update' => 'cascade'
             ])
             ->create()
        ;
    }
}
