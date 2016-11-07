<?php
namespace ZEA2\Platform\Markers\SerialEntity;

trait SerialEntityTrait
{
    /**
     * @Column(name="position", type="integer")
     * @var int
     */
    private $position = SerialManager::POSITION_START;

    public function getPosition(): int
    {
        return $this->position;
    }

    public function setPosition(int $position)
    {
        if($position < SerialManager::POSITION_START) {
            throw new \Exception(sprintf('Position should be greater than %d', $position));
        }

        $this->position = $position;

        return $this;
    }

    public function incrementPosition()
    {
        ++$this->position;

        return $this;
    }
}