<?php
namespace CASS\Application\PHPUnit\TestCase\Expectations\Traits;

use CASS\Application\PHPUnit\TestCase\Expectations\ExpectId;
use CASS\Application\PHPUnit\TestCase\Expectations\ExpectImageCollection;
use CASS\Application\PHPUnit\TestCase\Expectations\ExpectString;
use CASS\Application\PHPUnit\TestCase\Expectations\ExpectUndefined;

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