<?php

use Phinx\Migration\AbstractMigration;

class ProfileImageCollectionMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('profile')
            ->dropForeignKey('profile_greetings_id')
            ->dropForeignKey('profile_image_id')
            ->addColumn('image', 'text')
            ->addColumn('greetings', 'text')
            ->removeColumn('interesting_in_ids')
            ->removeColumn('expert_in_ids')
            ->addColumn('interesting_in_ids', 'text')
            ->addColumn('expert_in_ids', 'text')
        ->save();

        $this->dropTable('profile_greetings');
        $this->dropTable('profile_image');
    }
}
