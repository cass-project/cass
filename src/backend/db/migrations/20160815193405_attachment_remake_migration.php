<?php

use Phinx\Migration\AbstractMigration;

class AttachmentRemakeMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('post_attachment')->drop();
        
        $this->table('attachment')
            ->addColumn('sid', 'string')
            ->addColumn('date_created_on', 'datetime', [
                'null' => false
            ])
            ->addColumn('date_attached_on', 'datetime', [
                'null' => true
            ])
            ->addColumn('is_attached', 'boolean')
            ->addColumn('owner_id', 'integer', [
                'null' => true
            ])
            ->addColumn('owner_code', 'string', [
                'null' => true
            ])
            ->addColumn('metadata', 'text')
        ->create();
    }
}
