<?php
namespace Common\Tests;

use Interop\Container\ContainerInterface;
use Zend\Expressive\Application;

class TestCase extends \PHPUnit_Framework_TestCase
{
    /** @var ContainerInterface */
    protected static $container;

    public static function setUpBeforeClass()
    {
        global $application; /** @var Application $application */

        self::$container = $application->getContainer();
    }

    protected function getContainer()
    {
        return self::$container;
    }
}