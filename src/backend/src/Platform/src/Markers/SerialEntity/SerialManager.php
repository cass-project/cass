<?php
namespace ZEA2\Platform\Markers\SerialEntity;

class SerialManager
{
    /** @var SerialEntity[] */
    private $entities;

    const POSITION_START = 1;
    const POSITION_LAST = -1;

    public function __construct(array $entities)
    {
        $this->entities = $entities;
        $this->normalize();
    }

    public function getEntities(): array
    {
        return $this->entities;
    }

    public function normalize()
    {
        $counter = self::POSITION_START;

        uasort($this->entities, function(SerialEntity $a, SerialEntity $b) {
            /** @var SerialEntity[] $sortedEntities */
            return $a->getPosition() <=> $b->getPosition();
        });

        foreach($this->entities as $entity) {
            $entity->setPosition($counter++);
        }
    }

    public function insertAs(SerialEntity $entity, int $toPosition = self::POSITION_LAST)
    {
        if($toPosition === self::POSITION_LAST) {
            $toPosition = $this->max() + 1;
        }

        if($toPosition >= $this->max()) {
            $entity->setPosition($this->max() + 1);
        }else{

            if($this->has($entity)) {
                $this->swap($entity, $this->locate($toPosition));
            }else{
                foreach($this->entities as $shiftEntity) {
                    if($shiftEntity->getPosition() >= $toPosition) {
                        $shiftEntity->incrementPosition();
                    }
                }

                $entity->setPosition($toPosition);

                $this->entities[] = $entity;
            }
        }

        $this->normalize();
    }

    public function up(SerialEntity $entity)
    {
        if($entity->getPosition() > 1) {
            $this->insertAs($entity, $entity->getPosition() - 1);
        }
    }

    public function down(SerialEntity $entity)
    {
        $this->insertAs($entity, $entity->getPosition() + 1);
    }

    public function swap(SerialEntity $entityA, SerialEntity $entityB)
    {
        if(! ($this->has($entityA) && $this->has($entityB))) {
            throw new \Exception('You can\'t use method swap with these entities');
        }

        $swap = $entityA->getPosition();
        $entityA->setPosition($entityB->getPosition());
        $entityB->setPosition($swap);

        $this->normalize();
    }

    public function insertLast(SerialEntity $entity)
    {
        if($this->has($entity)) {
            $entity->setPosition($this->max() + 1);
        }else{
            $entity->setPosition($this->next());
            $this->entities[] = $entity;
        }

        $this->normalize();
    }

    public function remove(SerialEntity $entity)
    {
        if($this->has($entity)) {
            $entity->setPosition(self::POSITION_START);
            $key = $this->getKey($entity);
            unset($this->entities[$key]);
        }

        $this->normalize();
    }

    public function locate($position): SerialEntity
    {
        foreach($this->entities as $entity) {
            if($entity->getPosition() === $position) {
                return $entity;
            }
        }

        throw new \OutOfBoundsException('Entity with position `%d` is not available');
    }

    private function getKey(SerialEntity $entity)
    {
        foreach($this->entities as $key => $compare) {
            if($compare === $entity) {
                return $key;
            }
        }

        throw new \OutOfBoundsException('Entity not found');
    }

    private function max()
    {
        return count($this->entities);
    }

    private function next()
    {
        return $this->max() + 1;
    }

    private function has(SerialEntity $entity)
    {
        foreach($this->entities as $compare) {
            if($compare === $entity) {
                return true;
            }
        }

        return false;
    }
}