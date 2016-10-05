<?php

namespace CASS\Chat\Service;

use CASS\Chat\Entity\Message;
use CASS\Chat\Repository\MessageRepository;

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
}