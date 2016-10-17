<?php

namespace CASS\Chat\Service;

use CASS\Chat\Entity\Message;
use CASS\Chat\Repository\MessageRepository;
use CASS\Domain\Bundles\Profile\Entity\Profile;
use CASS\Util\Seek;

class MessageService
{

    /** @var MessageRepository */
    private $messageRepository;

    public function __construct(MessageRepository $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    public function createMessage(Message $message): Message
    {
        return $this->messageRepository->createMessage($message);
    }

    public function getMessagesToProfile(Profile $sourcePofile, Profile $targetProfile, Seek $seek): array
    {

        return $this->messageRepository->findBy([
            'sourceId' => [ $targetProfile->getId(), $sourcePofile->getId()] ,
            'sourceType' => Message::SOURCE_TYPE_PROFILE,
            'targetType' => Message::TARGET_TYPE_PROFILE,
            'targetId' => [ $targetProfile->getId(), $sourcePofile->getId()]
        ], ['id' => 'DESC'],$seek->getLimit(), $seek->getOffset());
    }
}