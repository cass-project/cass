<?php
namespace Domain\ProfileIM\Service;

use Domain\IM\Entity\Message;
use Domain\IM\Exception\Query\UnknownSourceException;
use Domain\IM\Query\Query;
use Domain\IM\Query\Source\CommunitySource\CommunitySource;
use Domain\IM\Query\Source\ProfileSource\ProfileSource;
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

    public function sendMessage(Source $source, Message $message): ObjectID
    {
        $insertedId = $this->imRepository->createMessage($source, $message);

        $message->specifyId($insertedId);

        array_map(function(int $targetId) use ($source, $insertedId) {
            $this->imRepository->pushNotification($source, $targetId, $insertedId);
        }, $this->getNotificationTargetIds($source));

        return $insertedId;
    }

    public function getMessages(Query $query, Profile $target)
    {
        return $this->imRepository->getMessages($query, $target->getId());
    }

    public function unreadMessages(int $targetId)
    {
        return $this->imRepository->getNotifications($targetId);
    }

    private function getNotificationTargetIds(Source $source): array
    {
        if($source instanceof ProfileSource) {
            return [$source->getTargetProfileId()];
        }else if($source instanceof CommunitySource) {
            return [];
        }else{
            throw new UnknownSourceException(sprintf('No idea how to send notification for source `%s`', get_class($source)));
        }
    }
}