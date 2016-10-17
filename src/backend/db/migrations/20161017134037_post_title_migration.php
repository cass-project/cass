<?php

use Phinx\Migration\AbstractMigration;

class PostTitleMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('post')
            ->addColumn('title', 'string', [
                'limit' => 256,
                'null' => true
            ])
            ->save();
    }
}
