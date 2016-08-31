<?php
namespace CASS\Application\PHPUnit;

use Doctrine\ORM\EntityManager;
use Zend\Expressive\Application;

interface Fixture
{
    public function up(Application $app, EntityManager $em);
}