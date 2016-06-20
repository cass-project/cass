<?php

use Phinx\Migration\AbstractMigration;

class CollectionRewampMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('collection')
            ->dropForeignKey('author_profile_id')
            ->dropForeignKey('theme_id')
            ->addColumn('theme_ids', 'text')
            ->addColumn('sid', 'string', ['length' => 12])
            ->save();
    }
}
