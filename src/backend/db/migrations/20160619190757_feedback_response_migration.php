<?php

use Phinx\Migration\AbstractMigration;

class FeedbackResponseMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('feedback_response')
             ->addColumn('created_at', 'datetime')
             ->addColumn('description', 'text')
             ->addColumn('feedback_id', 'integer')
             ->addForeignKey('feedback_id', 'feedback', 'id')
             ->create();
    }
}
