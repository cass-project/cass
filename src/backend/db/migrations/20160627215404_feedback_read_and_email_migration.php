<?php

use Phinx\Migration\AbstractMigration;

class FeedbackReadAndEmailMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('feedback')
            ->addColumn('feedback_read', 'boolean')
            ->addColumn('email', 'string', [
                'null' => true
            ])
            ->save();
    }
}
