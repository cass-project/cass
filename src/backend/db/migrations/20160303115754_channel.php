<?php

use Phinx\Migration\AbstractMigration;

class Channel extends AbstractMigration
{

    CONST TABLE_NAME = 'channel';
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
        // Adding account table
        $this->table(self::TABLE_NAME)
             ->addColumn('name', 'string')
             ->addColumn('description', 'string')
             ->addColumn('created', 'datetime')
             ->addColumn('updated', 'datetime', array('null' => TRUE))
             ->addColumn('status', 'string')
             ->addColumn('account_id', 'integer', array('null' => TRUE))
              ->addForeignKey('account_id', 'account',
                              'id', ['delete' => 'NO_ACTION',
                                     'update' => 'NO_ACTION'
                              ]
              )
              ->addColumn('theme_id', 'integer', array('null' => TRUE))
              ->addForeignKey('theme_id', 'theme',
                              'id', ['delete' => 'NO_ACTION',
                                     'update' => 'NO_ACTION'
                              ]
              )
             ->create();
        $this->insertData();
    }

    private function insertData()
    {
      $date_time = (new \DateTime())->format("Y-m-d");

      $this->table(self::TABLE_NAME)->insert([
         [
           'name'    => 'Канал о политике 1',
           'description' => '1 Наш канал создан исключительно в развлекательных целях и не имеет цель оскорбить или опорочить кого либо. Наши ролики создаются в жанре литературной, музыкальной или иной пародии,в жанре карикатуры на основе другого (оригинального) правомерно обнародованного произведения.',
           'created'=> $date_time,
           'updated'=> $date_time,
           'status' => '1'
         ],
         [
           'name'    => 'Канал о политике 2',
           'description' => '2 Наш канал создан исключительно в развлекательных целях и не имеет цель оскорбить или опорочить кого либо. Наши ролики создаются в жанре литературной, музыкальной или иной пародии,в жанре карикатуры на основе другого (оригинального) правомерно обнародованного произведения.',
           'created'=> $date_time,
           'updated'=> $date_time,
           'status' => '1'
         ],
         [
           'name'    => 'Канал о политике 3',
           'description' => '3 Наш канал создан исключительно в развлекательных целях и не имеет цель оскорбить или опорочить кого либо. Наши ролики создаются в жанре литературной, музыкальной или иной пародии,в жанре карикатуры на основе другого (оригинального) правомерно обнародованного произведения.',
           'created'=> $date_time,
           'updated'=> $date_time,
           'status' => '1'
         ],
         [
           'name'    => 'Канал о политике 4',
           'description' => '4 Наш канал создан исключительно в развлекательных целях и не имеет цель оскорбить или опорочить кого либо. Наши ролики создаются в жанре литературной, музыкальной или иной пародии,в жанре карикатуры на основе другого (оригинального) правомерно обнародованного произведения.',
           'created'=> $date_time,
           'updated'=> $date_time,
           'status' => '1'
         ]
      ]
      )->saveData();
    }
}
