<?php
namespace Domain\Collection\Service\Parameters\CollectionService;


class CollectionMoveParameters
{
    /** @var int */
    private $collectionId;

    /** @var int */
    private $moveToParentCollectionId;

    /** @var int */
    private $moveToPosition;

    public function __construct(int $collectionId, int $moveToParentCollectionId, int $moveToPosition)
    {
        $this->collectionId = $collectionId;
        $this->moveToParentCollectionId = $moveToParentCollectionId;
        $this->moveToPosition = $moveToPosition;
    }

    public function getCollectionId(): int
    {
        return $this->collectionId;
    }

    public function getMoveToParentCollectionId(): int
    {
        return $this->moveToParentCollectionId;
    }

    public function getMoveToPosition(): int
    {
        return $this->moveToPosition;
    }
}