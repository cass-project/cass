<?php
namespace Application\Tests;

use Common\Tools\SerialManager\SerialEntity;
use Common\Tools\SerialManager\SerialManager;

/**
 * @backupGlobals disabled
 */
class SerialManagerTest extends \PHPUnit_Framework_TestCase
{
    const HOW_MANY_STACKS_HAS_NASUS = 800;

    /**
     * @return SerialEntityExample[]
     */
    private function getExampleEntities(): array
    {
        return [
            'annie' => new SerialEntityExample("annie", 1),
            'lulu' => new SerialEntityExample("lulu", 2),
            'evelynn' => new SerialEntityExample("evelynn", 3),
            'irelia' => new SerialEntityExample("irelia", 4),
            'syndra' => new SerialEntityExample("syndra", 5),
        ];
    }

    /**
     * @param $entities SerialEntityExample[]
     */
    private function assertExampleEntities($entities)
    {
        $this->assertEquals(1, $entities['annie']->getPosition());
        $this->assertEquals(2, $entities['lulu']->getPosition());
        $this->assertEquals(3, $entities['evelynn']->getPosition());
        $this->assertEquals(4, $entities['irelia']->getPosition());
        $this->assertEquals(5, $entities['syndra']->getPosition());
    }

    public function testInsertLast()
    {
        $entities = $this->getExampleEntities();

        $udyrEntity = new SerialEntityExample('udyr');

        $serialManager = new SerialManager($entities);
        $serialManager->insertLast($udyrEntity);

        $this->assertExampleEntities($serialManager->getEntities());
        $this->assertEquals(6, $udyrEntity->getPosition());
    }

    public function testInsertAsFirst()
    {
        $udyrEntity = new SerialEntityExample('udyr');

        $entities = $this->getExampleEntities();

        $serialManager = new SerialManager($entities);
        $serialManager->insertAs($udyrEntity, 1);

        $this->assertEquals(1, $udyrEntity->getPosition());
        $this->assertEquals(2, $entities['annie']->getPosition());
        $this->assertEquals(3, $entities['lulu']->getPosition());
        $this->assertEquals(4, $entities['evelynn']->getPosition());
        $this->assertEquals(5, $entities['irelia']->getPosition());
        $this->assertEquals(6, $entities['syndra']->getPosition());
    }

    public function testInsertAsLast()
    {
        $udyrEntity = new SerialEntityExample('udyr');

        $entities = $this->getExampleEntities();

        $serialManager = new SerialManager($entities);
        $serialManager->insertAs($udyrEntity, 6);

        $this->assertEquals(1, $entities['annie']->getPosition());
        $this->assertEquals(2, $entities['lulu']->getPosition());
        $this->assertEquals(3, $entities['evelynn']->getPosition());
        $this->assertEquals(4, $entities['irelia']->getPosition());
        $this->assertEquals(5, $entities['syndra']->getPosition());
        $this->assertEquals(6, $udyrEntity->getPosition());
    }

    public function testInsertAsBetween()
    {
        $udyrEntity = new SerialEntityExample('udyr');

        $entities = $this->getExampleEntities();

        $serialManager = new SerialManager($entities);
        $serialManager->insertAs($udyrEntity, 4);

        $this->assertEquals(1, $entities['annie']->getPosition());
        $this->assertEquals(2, $entities['lulu']->getPosition());
        $this->assertEquals(3, $entities['evelynn']->getPosition());
        $this->assertEquals(4, $udyrEntity->getPosition());
        $this->assertEquals(5, $entities['irelia']->getPosition());
        $this->assertEquals(6, $entities['syndra']->getPosition());
    }

    public function testInsertAsZero()
    {
        $udyrEntity = new SerialEntityExample('udyr');

        $entities = $this->getExampleEntities();

        $serialManager = new SerialManager($entities);
        $serialManager->insertAs($udyrEntity, 0);

        $this->assertEquals(1, $udyrEntity->getPosition());
        $this->assertEquals(2, $entities['annie']->getPosition());
        $this->assertEquals(3, $entities['lulu']->getPosition());
        $this->assertEquals(4, $entities['evelynn']->getPosition());
        $this->assertEquals(5, $entities['irelia']->getPosition());
        $this->assertEquals(6, $entities['syndra']->getPosition());
    }

    public function testInsertAsNegative()
    {
        $udyrEntity = new SerialEntityExample('udyr');

        $entities = $this->getExampleEntities();

        $serialManager = new SerialManager($entities);
        $serialManager->insertAs($udyrEntity, -10);

        $this->assertEquals(1, $udyrEntity->getPosition());
        $this->assertEquals(2, $entities['annie']->getPosition());
        $this->assertEquals(3, $entities['lulu']->getPosition());
        $this->assertEquals(4, $entities['evelynn']->getPosition());
        $this->assertEquals(5, $entities['irelia']->getPosition());
        $this->assertEquals(6, $entities['syndra']->getPosition());
    }

    public function testInsertAsOutOfMax()
    {
        $udyrEntity = new SerialEntityExample('udyr');

        $entities = $this->getExampleEntities();

        $serialManager = new SerialManager($entities);
        $serialManager->insertAs($udyrEntity, self::HOW_MANY_STACKS_HAS_NASUS);

        $this->assertEquals(1, $entities['annie']->getPosition());
        $this->assertEquals(2, $entities['lulu']->getPosition());
        $this->assertEquals(3, $entities['evelynn']->getPosition());
        $this->assertEquals(4, $entities['irelia']->getPosition());
        $this->assertEquals(5, $entities['syndra']->getPosition());
        $this->assertEquals(6, $udyrEntity->getPosition());
    }

    public function testRemoveFirst()
    {
        $entities = $this->getExampleEntities();

        $serialManager = new SerialManager($entities);
        $serialManager->remove($entities['annie']);

        $this->assertEquals(1, $entities['lulu']->getPosition());
        $this->assertEquals(2, $entities['evelynn']->getPosition());
        $this->assertEquals(3, $entities['irelia']->getPosition());
        $this->assertEquals(4, $entities['syndra']->getPosition());
    }

    public function testRemoveBetween()
    {
        $entities = $this->getExampleEntities();

        $serialManager = new SerialManager($entities);
        $serialManager->remove($entities['evelynn']);

        $this->assertEquals(1, $entities['annie']->getPosition());
        $this->assertEquals(2, $entities['lulu']->getPosition());
        $this->assertEquals(3, $entities['irelia']->getPosition());
        $this->assertEquals(4, $entities['syndra']->getPosition());
    }

    public function testRemoveLast()
    {
        $entities = $this->getExampleEntities();

        $serialManager = new SerialManager($entities);
        $serialManager->remove($entities['syndra']);

        $this->assertEquals(1, $entities['annie']->getPosition());
        $this->assertEquals(2, $entities['lulu']->getPosition());
        $this->assertEquals(3, $entities['evelynn']->getPosition());
        $this->assertEquals(4, $entities['irelia']->getPosition());
    }
}

class SerialEntityExample implements SerialEntity
{
    /** @var string */
    private $title;

    /** @var int */
    private $position;

    public function __construct(string $title, int $position = 0)
    {
        $this->title = $title;
        $this->position = $position;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function setPosition(int $position)
    {
        $this->position = $position;
    }

    public function incrementPosition()
    {
        ++$this->position;
    }
}