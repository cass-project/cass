<?php
namespace Domain\IM\Middleware\Command;

use Domain\Auth\Service\CurrentAccountService;
use Domain\IM\Formatter\MessageFormatter;
use Domain\IM\Query\QueryFactory;
use Domain\IM\Query\Source\SourceFactory;
use Domain\IM\Service\SourceEntityLookupService;
use Domain\IM\Service\IMService;

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

    /** @var SourceEntityLookupService */
    protected $sourceEntityLookupService;

    public function __construct(
        CurrentAccountService $currentAccountService,
        QueryFactory $queryFactory,
        IMService $imService,
        MessageFormatter $messageFormatter,
        SourceFactory $sourceFactory,
        SourceEntityLookupService $sourceEntityLookupService
    ) {
        $this->currentAccountService = $currentAccountService;
        $this->queryFactory = $queryFactory;
        $this->imService = $imService;
        $this->messageFormatter = $messageFormatter;
        $this->sourceFactory = $sourceFactory;
        $this->sourceEntityLookupService = $sourceEntityLookupService;
    }
}