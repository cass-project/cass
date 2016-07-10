<?php
use Phinx\Migration\AbstractMigration;

class PostMetadataMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('post')
            ->addColumn('metadata', 'text')
        ->save();
    }
}
