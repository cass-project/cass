<?php
namespace Domain\ProfileIM\Service;

use Domain\IM\Entity\Message;
use Domain\IM\Query\Query;
use Domain\IM\Query\Source\Source;
use Domain\IM\Repository\IMRepository;
use Domain\Profile\Entity\Profile;
use MongoDB\BSON\ObjectID;

final class IMService
{
    /** @var IMRepository */
    private $imRepository;

    public function __construct(IMRepository $imRepository)
    {
        $this->imRepository = $imRepository;
    }

    public function sendMessage(Source $source, Message $message, int $notificationTargetId): ObjectID
    {
        $insertedId = $this->imRepository->createMessage($source, $message);

        if($this->shouldWeSendNotification($source, $notificationTargetId, $insertedId)) {
            $this->imRepository->pushNotification($source, $notificationTargetId, $insertedId);
        }

        return $insertedId;
    }

    public function getMessages(Source $source, Query $query, Profile $target)
    {
        return $this->imRepository->getMessages($source, $query, $target->getId());
    }

    private function shouldWeSendNotification(Source $source, int $notificationTargetId, ObjectID $objectID): bool
    {
        return true;
    }

    public function unreadMessages(int $targetId)
    {
        return $this->imRepository->getNotifications($targetId);
    }
}