<?php
use Phinx\Migration\AbstractMigration;
class ChannelPost extends AbstractMigration
{
	CONST TABLE_NAME = 'channel_post';
	/**
	 * Change Method.
	 *
	 * Write your reversible migrations using this method.
	 *
	 * More information on writing migrations is available here:
	 * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
	 *
	 * The following commands can be used in this method and Phinx will
	 * automatically reverse them when rolling back:
	 *
	 *    createTable
	 *    renameTable
	 *    addColumn
	 *    renameColumn
	 *    addIndex
	 *    addForeignKey
	 *
	 * Remember to call "create()" or "update()" and NOT "save()" when working
	 * with the Table class.
	 */
	public function change()
	{
		$this->table(self::TABLE_NAME)
				 ->addColumn('channel_id', 'integer')
				 ->addForeignKey('channel_id', 'channel', 'id', [
					 'delete' => 'cascade',
					 'update' => 'cascade'
				 ])
				 ->addColumn('post_id', 'integer')
				 ->addForeignKey('post_id', 'post', 'id', [
					 'delete' => 'cascade',
					 'update' => 'cascade'
				 ])
				 ->create()
		;
	}
}
