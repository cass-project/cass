<?php

use Phinx\Migration\AbstractMigration;


class Post extends AbstractMigration
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

    const TABLE_NAME = 'post';


    public function change()
    {
        // Adding account table
        $this->table(self::TABLE_NAME)
             ->addColumn('description', 'string')
             ->addColumn('created', 'datetime')
             ->addColumn('updated', 'datetime',array('null' => true))
             ->addColumn('status', 'string')
            ->addForeignKey('account_id', User::TABLE_NAME, 'id', ['delete'=> 'SET_NULL', 'update'=> 'NO_ACTION'])
             ->create()
        ;
    }

}
