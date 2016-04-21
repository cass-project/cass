<?php
namespace ProfileIM\Repository;

use Common\Util\Seek;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use ProfileIM\Entity\ProfileMessage;

class ProfileMessageRepository extends EntityRepository
{

	public function getMessage($criteria)
	{

		return $this->find($criteria);
	}

	public function getMessageById($id)
	{
		$query = $this->createQueryBuilder('m')
			->where('m.id = :id')
			->setParameter('id', $id)
			->getQuery();

		return $products = $query->getResult();
	}

	/** @return ProfileMessage[] */
	public function getMessagesBySourceProfile(int $sourceProfileId, Seek $seek): array
	{
		return $this->findBy([
			'source_profile_id' => $sourceProfileId,
			'offset' => $seek->getOffset(),
			'limit' => $seek->getLimit(),
		]);
	}

	public function saveMessage(ProfileMessage $message): ProfileMessage
	{
		$em =$this->getEntityManager();
		$em->persist($message);
		$em->flush();

		return $message;
	}
}