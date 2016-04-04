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
    public function change()
    {
        $this->table('post')
             ->addColumn('account_id', 'integer', [
               'null' => true
             ])
             ->addColumn('name', 'string')
             ->addColumn('description', 'text')
             ->addColumn('created', 'datetime',['null' => true])
             ->addColumn('updated', 'datetime',['null' => true])
             ->addColumn('publish', 'string',['default'=> 'false'])
             ->addForeignKey('account_id', 'account', 'id', [
               'delete' => 'cascade',
               'update' => 'cascade'
             ])
             ->create()
        ;
      $this->insertData();
    }


  private function insertData(){
    $this->table('post')
      ->insert(
        [
          ['account_id'    => 2,
           'name' => "Имя 1 ",
           'description' => 'Описание 1',
           'created' => (new \DateTime())->format("Y-m-d H:i:s"),
           'updated' => (new \DateTime())->format("Y-m-d H:i:s"),
           'publish' => 'true',
          ],
          ['account_id'    => 2,
           'name' => "Имя 2 ",
           'description' => 'Описание 2',
           'created' => (new \DateTime())->format("Y-m-d H:i:s"),
           'updated' => (new \DateTime())->format("Y-m-d H:i:s"),
           'publish' => 'true',
          ],
          ['account_id'    => 2,
           'name' => "Имя 3 ",
           'description' => 'Описание 3',
           'created' => (new \DateTime())->format("Y-m-d H:i:s"),
           'updated' => (new \DateTime())->format("Y-m-d H:i:s"),
           'publish' => 'false',
          ],
        ]
    )->saveData();
  }
}
