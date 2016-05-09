<?php
namespace Application\Util;

use Common\Util\int;

trait IdTrait
{
    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer")
     * @var int
     */
    private $id;

    public function isPersisted() {
        return $this->id !== null;
    }

    public function getId(): int {
        return $this->id;
    }
}