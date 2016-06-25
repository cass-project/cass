<?php

use Phinx\Migration\AbstractMigration;

class FeedbackMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('feedback')
             ->addColumn('created_at', 'datetime')
             ->addColumn('profile_id', 'integer',['null'=> true ])
             ->addColumn('description', 'text')
             ->addColumn('type', 'string',['null' => true ])
             ->addForeignKey('profile_id', 'profile', 'id', [
               'update' => 'cascade',
               'delete' => 'restrict'
             ])
             ->create();
    }
}
