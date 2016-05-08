<?php
namespace Domain\ProfileIM\Repository;

use Application\Util\Seek;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Domain\ProfileIM\Entity\ProfileMessage;

class ProfileMessageRepository extends EntityRepository
{
	public function getMessageById($messageId): ProfileMessage
	{
		return $this->find($messageId);
	}
	
	public function getMessages(int $sourceProfileId, int $targetProfileId, Seek $seek): array
	{
		/** @var ProfileMessage[] $result */
		$result = $this->findBy([
			'sourceProfile' => $sourceProfileId,
			'targetProfile' => $targetProfileId,
		], ['id' => 'desc'], $seek->getLimit(), $seek->getOffset());

		return $result;
	}

	public function createMessage(ProfileMessage $message): ProfileMessage
	{
		$em = $this->getEntityManager();
		$em->persist($message);
		$em->flush();

		return $message;
	}

	public function updateMessages(array $messages)
	{
		$em = $this->getEntityManager();
		array_walk( $messages,
			function (ProfileMessage $message) use ($em){
				$em->persist($message);
			}
		);
		$em->flush();
		return $messages;
	}

	public function getUnreadMessagesByProfile($profileId): array
	{
		return $this->findBy([
				 'targetProfile' => $profileId,
				 'isRead'       => 0
	 	], ['id' => 'desc'], 100);
	}
}