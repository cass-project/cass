<?php
namespace ProfileIM\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use ProfileIM\Entity\ProfileMessage;

class ProfileMessageRepository extends EntityRepository
{

	public function getMessage($criteria){

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

	public function getMessageBy(array $criteria)
	{

		$qb = $this->createQueryBuilder('m, sp')
							->join('m.source_profile', 'sp');
							/*->where('m.id = :id')
							->setParameter('id', $criteria['source_profile']);*/

		/*if($criteria['source_profile']){
			$qb->where('m.id = :id')
				 ->setParameter('id', $criteria['source_profile']);

		}*/

		$query = $qb->getQuery();
		$products = $query->getResult(Query::HYDRATE_ARRAY);
	}




	public function saveMessage(ProfileMessage $message): ProfileMessage
	{
		$em =$this->getEntityManager();
		$em->persist($message);
		$em->flush();

		return $message;
	}
}