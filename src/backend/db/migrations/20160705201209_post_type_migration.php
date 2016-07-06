<?php

use Phinx\Migration\AbstractMigration;

class PostTypeMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('post')
            ->addColumn('post_type', 'integer', [
                'default' => false
            ])
            ->save();
    }
}
