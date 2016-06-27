<?php

use Phinx\Migration\AbstractMigration;

class FeedbackReadAndEmailMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('feedback')
            ->addColumn('read', 'boolean')
            ->addColumn('email', 'string', [
                'null' => true
            ])
            ->save();
    }
}
