<?php
namespace Common\Util\Definitions;

class InvalidCoordException extends \Exception {}

class Point
{
    /** @var int */
    private $x;

    /** @var int */
    private $y;

    public function __construct(int $x, int $y)
    {
        if($x < 0 || is_double($x)) {
            throw new InvalidCoordException(sprintf('Invalid X: `%s`', $x));
        }

        if($y < 0 || is_double($y)) {
            throw new InvalidCoordException(sprintf('Invalid Y: `%s`', $y));
        }

        $this->x = $x;
        $this->y = $y;
    }

    public function getX(): int
    {
        return $this->x;
    }

    public function getY(): int
    {
        return $this->y;
    }
}