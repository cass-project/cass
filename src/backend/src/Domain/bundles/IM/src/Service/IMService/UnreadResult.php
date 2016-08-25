<?php
namespace Domain\IM\Service\IMService;

use CASS\Util\JSONSerializable;

final class UnreadResult implements JSONSerializable
{
    /** @var string */
    private $source;

    /** @var int */
    private $sourceId;

    /** @var JSONSerializable */
    private $sourceEntity;

    /** @var int */
    private $counter;

    public function __construct(string $source, int $sourceId, JSONSerializable $sourceEntity, int $counter)
    {
        $this->source = $source;
        $this->sourceId = $sourceId;
        $this->sourceEntity = $sourceEntity;
        $this->counter = $counter;
    }

    public function toJSON(): array
    {
        return [
            'source' => [
                'code' => $this->getSource(),
                'id' => $this->getSourceId(),
                'entity' => $this->getSourceEntity()->toJSON()
            ],
            'counter' => $this->getCounter()
        ];
    }

    public function incrementCounter()
    {
        ++$this->counter;
    }

    public function getSource(): string
    {
        return $this->source;
    }

    public function getSourceId(): int
    {
        return $this->sourceId;
    }

    public function getSourceEntity(): JSONSerializable
    {
        return $this->sourceEntity;
    }

    public function getCounter(): int
    {
        return $this->counter;
    }
}