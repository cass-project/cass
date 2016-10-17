<?php
namespace CASS\Chat\Repository;

use CASS\Chat\Entity\Message;
use Doctrine\ORM\EntityRepository;

class MessageRepository extends EntityRepository
{
    const MAX_MESSAGES_LIMIT = 100;

    public function createMessage(Message $message): Message
    {
        $em = $this->getEntityManager();
        $em->persist($message);
        $em->flush();

        return $message;
    }

}