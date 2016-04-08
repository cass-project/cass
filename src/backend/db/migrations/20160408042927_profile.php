<?php

use Phinx\Migration\AbstractMigration;

class Profile extends AbstractMigration
{
    CONST TABLE_NAME = 'profile';

    public function change()
    {
        $this->table(self::TABLE_NAME)
            ->addColumn('call',       'string')
            ->addColumn('name',       'string',   ['null'    => true])
            ->addColumn('nick',       'string',   ['null'    => true])
            ->addColumn('surname',    'string',   ['null'    => true])
            ->addColumn('patronymic', 'string',   ['null'    => true])
            ->addColumn('gender',     'boolean',  ['default' => true])
            ->addColumn('birthday',   'date', ['null'    => true])
            ->addColumn('avatar',     'string',   ['null'    => true])
            ->addColumn('account_id', 'integer')
            ->create()
        ;
        $this->table(self::TABLE_NAME)->insert([
            ['call' => 'Василий', 'name' => 'Василий', 'account_id' => 0],
            ['call' => 'Luchok',  'name' => 'Алексей', 'nick' => 'Luchok', 'account_id' => 0],
            [
                'call' => 'Тёма',
                'name' => 'Артём',
                'nick' => 'hck',
                'birthday' => '1991-08-17',
                'account_id' => 1
            ],
            [
                'call' => 'Слава',
                'name' => 'Вячеслав',
                'surname' => 'Савушкин',
                'account_id' => 2
            ],
        ])->saveData();
    }
}
