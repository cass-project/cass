<?php
namespace ZEA2\Platform\Bundles\PHPUnit\TestCase\Expectations\Traits;

use ZEA2\Platform\Bundles\PHPUnit\TestCase\Expectations\ExpectId;
use ZEA2\Platform\Bundles\PHPUnit\TestCase\Expectations\ExpectImageCollection;
use ZEA2\Platform\Bundles\PHPUnit\TestCase\Expectations\ExpectString;
use ZEA2\Platform\Bundles\PHPUnit\TestCase\Expectations\ExpectUndefined;

trait AllExpectationsTrait
{
    protected function expectId():  ExpectId {
        return new ExpectId();
    }

    protected function expectString(): ExpectString {
        return new ExpectString();
    }

    protected function expectUndefined(): ExpectUndefined {
        return new ExpectUndefined();
    }

    protected function expectImageCollection(): ExpectImageCollection {
        return new  ExpectImageCollection();
    }
}