<?php

use Phinx\Migration\AbstractMigration;

class AttachmentTitleDescriptionMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('attachment')
            ->addColumn('title', 'string', [
                'limit' => 127,
                'null' => false,
                'default' => ''
            ])
            ->addColumn('description', 'string', [
                'limit' => 1024,
                'null' => false,
                'default' => ''
            ])
            ->save();
    }
}
