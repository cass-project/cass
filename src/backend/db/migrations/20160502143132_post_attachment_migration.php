<?php

use Phinx\Migration\AbstractMigration;

class PostAttachmentMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('post_attachment')
            ->addColumn('date_created_on', 'datetime')
            ->addColumn('post_id', 'integer', ['null' => true])
            ->addColumn('is_attached_to_post', 'boolean')
            ->addColumn('attachment_type', 'string')
            ->addColumn('attachment', 'text')
            ->addForeignKey('post_id', 'post', 'id', [
                'update' => 'cascade',
                'delete' => 'cascade'
            ])
        ->create();
    }
}
