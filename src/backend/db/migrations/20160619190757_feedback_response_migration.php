<?php

use Phinx\Migration\AbstractMigration;

class FeedbackResponseMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('feedback_response')
             ->addColumn('created_at', 'datetime')
             ->addColumn('description', 'text')
             ->addColumn('report_types', 'string',['null' => true ])
             ->addColumn('feedback_id', 'integer')
             ->addForeignKey('feedback_id', 'feedback', 'id', [
               'update' => 'cascade',
               'delete' => 'restrict'
             ])
             ->create();
    }
}
