<?php
namespace Domain\IM\Repository;

use Domain\IM\Entity\Message;
use Domain\IM\Entity\MessageReadStatus;
use Domain\IM\Query\Criteria\CursorCriteria\CursorCriteria;
use Domain\IM\Query\Criteria\SeekCriteria\SeekCriteria;
use Domain\IM\Query\Criteria\SortCriteria\SortCriteria;
use Domain\IM\Query\Query;
use Domain\IM\Query\Source\Source;
use MongoDB\BSON\ObjectID;

class IMRepository
{
    /** @var \MongoDB\Database */
    private $mongoDB;

    const NOTIFY_MONGO_DB_COLLECTION = 'im_push_%d';

    public function __construct(\MongoDB\Database $mongoDB)
    {
        $this->mongoDB = $mongoDB;
    }

    public function createMessage(Source $source, Message $message): ObjectID
    {
        $bson = $message->toMongoBSON();

        $collection = $this->mongoDB->selectCollection($source->getMongoDBCollectionName());
        $insertedId = $collection->insertOne($bson)->getInsertedId();

        return $insertedId;
    }

    public function getMessages(Source $source, Query $query)
    {
        $criteria = [];
        $options = [];

        $collection = $this->mongoDB->selectCollection($source->getMongoDBCollectionName());

        $query->getCriteria()->requireWith(SeekCriteria::class, function(SeekCriteria $seekCriteria) use (&$options) {
            $options['limit'] = $seekCriteria->getLimit();
            $options['skip'] = $seekCriteria->getOffset();
        });

        $query->getCriteria()->doWith(CursorCriteria::class, function(CursorCriteria $cursorCriteria) use (&$filter) {
            $lastId = new ObjectID($cursorCriteria->getId());

            $filter['_id'] = [
                '$gt' => $lastId
            ];
        });

        $query->getCriteria()->doWith(SortCriteria::class, function(SortCriteria $sortCriteria) use ($options) {
            $options['sort'] = [];
            $options['sort'][$sortCriteria->getField()] = strtolower($sortCriteria->getOrder()) === 'asc' ? 1 : -1;
        });

        $cursor = $collection->find($criteria, $options);

        return $cursor->toArray();
    }

    public function markAsRead(Source $source, array $messageIds)
    {
        $collection = $this->mongoDB->selectCollection($source->getMongoDBCollectionName());
        $collection->updateMany([
            '_id' => array_map(function(int $messageId) {
                return new ObjectId($messageId);
            }, $messageIds)
        ], [
            '$set' => [
                'read_status' => (new MessageReadStatus(true, new \DateTime()))->toMongoBSON()
            ]
        ]);
    }

    public function cleanNotifications(int $sourceId, int $targetId, array $messageIds)
    {
        $collection = $this->mongoDB->selectCollection(sprintf(self::NOTIFY_MONGO_DB_COLLECTION, $targetId));
        $collection->deleteMany([
            'id' => ['$in' => $messageIds],
            'source' => $sourceId,
        ]);
    }

    public function getNotifications(int $targetId): array
    {
        $collection = $this->mongoDB->selectCollection(sprintf(self::NOTIFY_MONGO_DB_COLLECTION, $targetId));

        return $collection->find([], [])->toArray();
    }

    public function pushNotification(Source $source, int $targetId, ObjectID $messageId)
    {
        $collection = $this->mongoDB->selectCollection(sprintf(self::NOTIFY_MONGO_DB_COLLECTION, $targetId));
        $collection->insertOne([
            'source' => $source->getSourceId(),
            'message' => (string) $messageId
        ]);
    }
}