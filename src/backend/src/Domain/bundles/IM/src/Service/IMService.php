<?php
namespace CASS\Domain\IM\Service;

use CASS\Domain\IM\Entity\Message;
use CASS\Domain\IM\Exception\Query\UnknownSourceException;
use CASS\Domain\IM\Query\Query;
use CASS\Domain\IM\Query\Source\CommunitySource\CommunitySource;
use CASS\Domain\IM\Query\Source\ProfileSource\ProfileSource;
use CASS\Domain\IM\Query\Source\Source;
use CASS\Domain\IM\Query\Source\SourceFactory;
use CASS\Domain\IM\Repository\IMRepository;
use CASS\Domain\IM\Service\IMService\UnreadResult;
use CASS\Domain\Profile\Entity\Profile;
use CASS\Domain\Profile\Service\ProfileService;
use MongoDB\BSON\ObjectID;
use MongoDB\Model\BSONDocument;

final class IMService
{
    /** @var IMRepository */
    private $imRepository;

    /** @var SourceEntityLookupService */
    private $sourceEntityLookupService;

    /** @var SourceFactory */
    private $sourceFactory;

    /** @var ProfileService */
    private $profileService;

    public function __construct(
        IMRepository $imRepository,
        SourceEntityLookupService $sourceEntityLookupService,
        SourceFactory $sourceFactory,
        ProfileService $profileService
    ) {
        $this->imRepository = $imRepository;
        $this->sourceEntityLookupService = $sourceEntityLookupService;
        $this->sourceFactory = $sourceFactory;
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

    public function getMessages(Query $query)
    {
        return array_map(function(BSONDocument $document) {
            return $this->convertBSONToEntity($document);
        }, $this->imRepository->getMessages($query));
    }

    public function unreadMessages(int $targetId): array
    {
        $map = [];
        
        array_map(function(BSONDocument $document) use (&$map, $targetId) {
            $source = (string) $document['source'];
            $sourceId = (int) $document['source_id'];
            $key = sprintf('%s_%s', $source, $sourceId);

            if(! isset($map[$key])) {
                $map[$key] = new UnreadResult($source, $sourceId, $this->sourceEntityLookupService->getEntityForSource(
                    $this->sourceFactory->createSource($source, $sourceId, $targetId)
                ), 0);
            }

            /** @var UnreadResult $result */
            $result = $map[$key];
            $result->incrementCounter();
        }, $this->imRepository->getNotifications($targetId)->toArray());

        return array_values($map);
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