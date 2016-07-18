<?php

use Phinx\Migration\AbstractMigration;

class PostAttachmentIdsMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('post')
            ->dropForeignKey('post_attachment_id')
            ->addColumn('attachment_ids', 'text')
        ->save();
    }
}
