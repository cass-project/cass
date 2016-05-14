<?php
namespace Application\Doctrine2\Service;

use Application\CommandBus\Implementations\TransactionServiceInterface;
use Doctrine\ORM\EntityManager;

class MockTransactionService implements TransactionServiceInterface
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

    public function rollback() {
        $this->entityManager->rollback();
    }

    public function commit() {
        $this->entityManager->rollback();
    }
}