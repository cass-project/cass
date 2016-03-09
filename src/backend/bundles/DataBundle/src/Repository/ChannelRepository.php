<?php
/**
 * User: юзер
 * Date: 09.03.2016
 * Time: 15:43
 * To change this template use File | Settings | File Templates.
 */

namespace Data\Repository;


use Doctrine\ORM\EntityRepository;

class ChannelRepository extends EntityRepository
{
	public function getChannels(){
		return $this->findAll();
	}
}