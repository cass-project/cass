<?php
namespace ZEA2\Platform\Bundles\PHPUnit\TestCase\Expectations;

use ZEA2\Platform\Bundles\PHPUnit\TestCase\MiddlewareTestCase;

final class ExpectationParams
{
    /** @var MiddlewareTestCase */
    private $case;

    /** @var mixed */
    private $level;

    /** @var array */
    private $actual;

    /** @var array */
    private $expected;

    /** @var string */
    private $key;

    /** @var mixed */
    private $value;

    public function __construct(MiddlewareTestCase $case, $level, array $actual, array $expected, string $key, $value)
    {
        $this->case = $case;
        $this->level = $level;
        $this->actual = $actual;
        $this->expected = $expected;
        $this->key = $key;
        $this->value = $value;
    }

    public function getCase(): MiddlewareTestCase
    {
        return $this->case;
    }

    public function getLevel()
    {
        return $this->level;
    }

    public function getActual(): array
    {
        return $this->actual;
    }

    public function getExpected(): array
    {
        return $this->expected;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getValue()
    {
        return $this->value;
    }
}