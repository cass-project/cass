<?php
/**
 * User: юзер
 * Date: 09.03.2016
 * Time: 15:43
 * To change this template use File | Settings | File Templates.
 */

namespace Data\Repository\Channel;


use Data\Entity\Channel;
use Data\Repository\Channel\Parameters\CreateChannelParemeters;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class ChannelRepository extends EntityRepository
{
	public function getChannels(){

		return $this->createQueryBuilder('e')
									->select('e')
									->getQuery()
									->getResult(Query::HYDRATE_ARRAY);
	}

	public function create(CreateChannelParemeters $parameters){
		$channelEntity = new Channel();

		$this->setupEntity($channelEntity, $parameters);

		$em = $this->getEntityManager();
		$em->persist($channelEntity);
		$em->flush();

		return $channelEntity;
	}

	private function setupEntity(Channel $channelEntity, CreateChannelParemeters $saveChannelProperties)
	{
		$saveChannelProperties->getName()->on(function($value) use($channelEntity) {
			$channelEntity->setName($value);
		});

		$saveChannelProperties->getAccountId()->on(function($value) use($channelEntity) {
			$channelEntity->getAccountId($value);
		});

		$saveChannelProperties->getDescription()->on(function($value) use($channelEntity) {
			$channelEntity->getDescription($value);
		});

		$saveChannelProperties->getStatus()->on(function($value) use($channelEntity) {
			$channelEntity->getStatus($value);
		});

		$saveChannelProperties->getThemeId()->on(function($value) use($channelEntity) {
			$channelEntity->getThemeId($value);
		});

	}
}