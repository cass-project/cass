<?php
namespace ZEA2\Platform\Bundles\PHPUnit\TestCase\Expectations\Traits;

use ZEA2\Platform\Bundles\PHPUnit\TestCase\Expectations\ExpectId;
use ZEA2\Platform\Bundles\PHPUnit\TestCase\Expectations\ExpectString;
use ZEA2\Platform\Bundles\PHPUnit\TestCase\Expectations\ExpectUndefined;

trait AllExpectationsTrait
{
    public function expectId():  ExpectId {
        return new ExpectId();
    }

    public function expectString(): ExpectString {
        return new ExpectString();
    }

    public function expectUndefined(): ExpectUndefined {
        return new ExpectUndefined();
    }
}