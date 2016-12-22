<?php

use Phinx\Migration\AbstractMigration;

class MessageMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('message')
            ->addColumn('source_id', 'integer')
            ->addColumn('source_type', 'integer')
            ->addColumn('target_id', 'integer')
            ->addColumn('target_type', 'integer')
            ->addColumn('date_created', 'datetime')
            ->addColumn('created', 'datetime', ['null' => true])
            ->addColumn('mark_as_read', 'boolean')
            ->addColumn('content', 'text')
            ->create();
    }
}
