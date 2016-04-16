<?php
namespace Common\Factory;

use DI\Container;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class DoctrineRepositoryFactory
{
    /** @var string */
    private $entityClassName;

    public function __construct(string $entityClassName) {
        $this->entityClassName = $entityClassName;
    }

    public function __invoke(Container $container): EntityRepository {
        $em = $container->get(EntityManager::class); /** @var EntityManager $em */

        return $em->getRepository($this->entityClassName);
    }
}