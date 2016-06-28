<?php

use Phinx\Migration\AbstractMigration;

class FeedbackAnswerIdMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('feedback')
            ->addColumn('answer_id', 'integer', [
                'null' => true
            ])
            ->addForeignKey('answer_id', 'feedback_response', 'id', [
                'update' => 'cascade',
                'delete' => 'cascade'
            ])
            ->save()
        ;
    }
}
