<?php
namespace Domain\IM\Service;

use Domain\IM\Entity\Message;
use Domain\IM\Exception\Query\UnknownSourceException;
use Domain\IM\Query\Query;
use Domain\IM\Query\Source\CommunitySource\CommunitySource;
use Domain\IM\Query\Source\ProfileSource\ProfileSource;
use Domain\IM\Query\Source\Source;
use Domain\IM\Repository\IMRepository;
use Domain\Profile\Entity\Profile;
use Domain\Profile\Service\ProfileService;
use MongoDB\BSON\ObjectID;
use MongoDB\Model\BSONDocument;

final class IMService
{
    /** @var IMRepository */
    private $imRepository;

    /** @var ProfileService */
    private $profileService;

    public function __construct(
        IMRepository $imRepository,
        ProfileService $profileService
    ) {
        $this->imRepository = $imRepository;
        $this->profileService = $profileService;
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
        return array_map(function(BSONDocument $document) {
            return $this->convertBSONToEntity($document);
        }, $this->imRepository->getMessages($query, $target->getId()));
    }

    public function unreadMessages(int $targetId)
    {
        return $this->imRepository->getNotifications($targetId);
    }

    public function convertBSONToEntity(BSONDocument $document): Message
    {
        /** @var ObjectID $id */
        $id = $document['_id'];

        $message = new Message(
            $this->profileService->getProfileById((int) $document['author_id']),
            (string) $document['content'],
            $document['attachment_ids']->getArrayCopy(),
            \DateTime::createFromFormat(\DateTime::RFC2822, $document['date_created'])
        );
        
        $message->specifyId($id);

        return $message;
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