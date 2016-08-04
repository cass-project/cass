<?php

use Phinx\Migration\AbstractMigration;

class ThemePreviewUrlMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('theme')
            ->addColumn('url', 'string')
            ->addColumn('preview', 'string')
        ->save();
    }
}
