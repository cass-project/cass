<?php
namespace Application\Service;

use Doctrine\ORM\EntityManager;

class TransactionService
{
    /** @var EntityManager */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function beginTransaction() {
        $this->entityManager->beginTransaction();
    }

    public function commit() {
        $this->entityManager->commit();
    }

    public function rollback() {
        $this->entityManager->rollback();
    }
}