<?php

use Phinx\Migration\AbstractMigration;

class ThemeDescriptionMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('theme')
            ->addColumn('description', 'text')
        ->save();
    }
}
