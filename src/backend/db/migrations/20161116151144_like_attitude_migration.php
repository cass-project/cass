<?php

use Phinx\Migration\AbstractMigration;

class LikeAttitudeMigration extends AbstractMigration
{
    public function change()
    {
        $this->table('like_attitude_log')
            ->addColumn('owner_type', 'integer', ['null' => false])
            ->addColumn('profile_id', 'integer', ['null' => true])
            ->addColumn('ip_address', 'string', ['null' => true])
            ->addColumn('attitude_type', 'integer', ['null' => false])
            ->addColumn('resource_id', 'integer', ['null' => false])
            ->addColumn('resource_type', 'integer', ['null' => false])
            ->addColumn('created', 'datetime', ['null' => false])
            ->save();
    }
}
