<?php

use Phinx\Migration\AbstractMigration;

class CommunityThemeFlagsMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('community')
            ->changeColumn('theme_id', 'integer', [
                'null' => true
            ])
            ->addColumn('public_enabled', 'boolean')
            ->addColumn('public_moderation_contract', 'boolean')
        ->save();
    }
}
