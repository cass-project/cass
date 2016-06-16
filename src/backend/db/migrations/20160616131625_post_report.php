<?php

use Phinx\Migration\AbstractMigration;

class PostReport extends AbstractMigration
{
    public function change()
    {
        $this->table('post_report')
             ->addColumn('created_at', 'datetime')
             ->addColumn('profile_id', 'integer')
             ->addColumn('description', 'text')
             ->addColumn('report_types', 'string',['null' => true ])
             ->addForeignKey('profile_id', 'profile', 'id', [
               'update' => 'cascade',
               'delete' => 'restrict'
             ])
             ->create();
    }
}
