<?php
namespace Domain\IM\Middleware\Command;

use Domain\Auth\Service\CurrentAccountService;
use Domain\IM\Query\QueryFactory;
use Domain\ProfileIM\Service\IMService;

abstract class Command implements \Application\Command\Command
{
    /** @var CurrentAccountService */
    protected $currentAccountService;
    
    /** @var QueryFactory */
    protected $queryFactory;

    /** @var IMService */
    protected $imService;


    public function __construct(
        CurrentAccountService $currentAccountService,
        QueryFactory $queryFactory,
        IMService $imService
    ) {
        $this->currentAccountService = $currentAccountService;
        $this->queryFactory = $queryFactory;
        $this->imService = $imService;
    }
}