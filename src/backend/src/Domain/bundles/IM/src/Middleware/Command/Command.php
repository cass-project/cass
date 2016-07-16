<?php
namespace Domain\IM\Middleware\Command;

use Domain\Auth\Service\CurrentAccountService;
use Domain\IM\Formatter\MessageFormatter;
use Domain\IM\Query\QueryFactory;
use Domain\IM\Query\Source\SourceFactory;
use Domain\Profile\Service\WithProfileService;
use Domain\ProfileIM\Service\IMService;

abstract class Command implements \Application\Command\Command
{
    /** @var CurrentAccountService */
    protected $currentAccountService;
    
    /** @var QueryFactory */
    protected $queryFactory;

    /** @var IMService */
    protected $imService;

    /** @var MessageFormatter */
    protected $messageFormatter;
    
    /** @var SourceFactory */
    protected $sourceFactory;

    /** @var WithProfileService */
    protected $withProfileService;

    public function __construct(
        CurrentAccountService $currentAccountService,
        QueryFactory $queryFactory,
        IMService $imService,
        MessageFormatter $messageFormatter
    ) {
        $this->currentAccountService = $currentAccountService;
        $this->queryFactory = $queryFactory;
        $this->imService = $imService;
        $this->messageFormatter = $messageFormatter;
    }
}