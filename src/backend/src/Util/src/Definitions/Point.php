<?php
namespace CASS\Util\Definitions;

use CASS\Util\Exception\InvalidCoordinatesException;

class Point
{
    /** @var int */
    private $x;

    /** @var int */
    private $y;

    public function __construct(int $x, int $y) {
        if ($x < 0 || is_double($x)) {
            throw new InvalidCoordinatesException(sprintf('Invalid X: `%s`', $x));
        }

        if ($y < 0 || is_double($y)) {
            throw new InvalidCoordinatesException(sprintf('Invalid Y: `%s`', $y));
        }

        $this->x = $x;
        $this->y = $y;
    }

    public function getX(): int {
        return $this->x;
    }

    public function getY(): int {
        return $this->y;
    }
}