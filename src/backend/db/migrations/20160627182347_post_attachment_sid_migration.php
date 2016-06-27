<?php

use Phinx\Migration\AbstractMigration;

class PostAttachmentSidMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('post_attachment')
            ->addColumn('sid', 'string')
            ->addIndex('sid', [
                'unique' => true
            ])
            ->save();
    }
}
