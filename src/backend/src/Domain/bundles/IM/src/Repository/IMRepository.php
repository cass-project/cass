<?php
namespace CASS\Domain\Bundles\IM\Repository;

use CASS\Domain\Bundles\IM\Entity\Message;
use CASS\Domain\Bundles\IM\Query\Options\MarkAsReadOption\MarkAsReadOption;
use CASS\Domain\Bundles\IM\Query\Criteria\CursorCriteria\CursorCriteria;
use CASS\Domain\Bundles\IM\Query\Criteria\SeekCriteria\SeekCriteria;
use CASS\Domain\Bundles\IM\Query\Criteria\SortCriteria\SortCriteria;
use CASS\Domain\Bundles\IM\Query\Query;
use CASS\Domain\Bundles\IM\Query\Source\Source;
use MongoDB\BSON\ObjectID;
use MongoDB\Driver\Cursor;

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

    public function getMessages(Query $query)
    {
        $source = $query->getSource();

        $order = 1;
        $criteria = [];
        $options = [];

        $collection = $this->mongoDB->selectCollection($source->getMongoDBCollectionName());

        $query->getCriteria()->requireWith(SeekCriteria::class, function(SeekCriteria $seekCriteria) use (&$options) {
            $options['limit'] = $seekCriteria->getLimit();
            $options['skip'] = $seekCriteria->getOffset();
        });

        $query->getCriteria()->doWith(SortCriteria::class, function(SortCriteria $sortCriteria) use (&$options, &$order) {
            $order = strtolower($sortCriteria->getOrder()) === 'asc' ? 1 : -1;

            $options['sort'] = [];
            $options['sort'][$sortCriteria->getField()] = $order;
        });

        $query->getCriteria()->doWith(CursorCriteria::class, function(CursorCriteria $cursorCriteria) use (&$criteria, $order) {
            $lastId = new ObjectID($cursorCriteria->getId());

            if($order === 1) {
                $criteria['_id'] = [
                    '$gt' => $lastId
                ];
            }else{
                $criteria['_id'] = [
                    '$lt' => $lastId
                ];
            }
        });

        $query->getOptions()->doWith(MarkAsReadOption::class, function(MarkAsReadOption $option) use ($source) {
            $this->cleanNotifications($source->getSourceId(), $option->getMessageIds());
        });

        $cursor = $collection->find($criteria, $options);

        return $cursor->toArray();
    }

    public function cleanNotifications(int $targetId, array $messageIds)
    {
        $collection = $this->mongoDB->selectCollection(sprintf(self::NOTIFY_MONGO_DB_COLLECTION, $targetId));
        $collection->deleteMany([
            'message_id' => ['$in' => $messageIds],
        ]);
    }

    public function getNotifications(int $targetId): Cursor
    {
        $collection = $this->mongoDB->selectCollection(sprintf(self::NOTIFY_MONGO_DB_COLLECTION, $targetId));

        return $collection->find([], [
            'limit' => 1000,
            'skip' => 0
        ]);
    }

    public function pushNotification(Source $source, int $targetId, ObjectID $messageId)
    {
        $collection = $this->mongoDB->selectCollection(sprintf(self::NOTIFY_MONGO_DB_COLLECTION, $targetId));
        $collection->insertOne([
            'source' => $source->getCode(),
            'source_id' => $source->getSourceId(),
            'message_id' => (string) $messageId
        ]);
    }
}