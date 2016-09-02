<?php
namespace CASS\Domain\Bundles\IM\Middleware\Command;

use CASS\Domain\Bundles\Auth\Service\CurrentAccountService;
use CASS\Domain\Bundles\IM\Formatter\MessageFormatter;
use CASS\Domain\Bundles\IM\Query\QueryFactory;
use CASS\Domain\Bundles\IM\Query\Source\SourceFactory;
use CASS\Domain\Bundles\IM\Service\SourceEntityLookupService;
use CASS\Domain\Bundles\IM\Service\IMService;

abstract class Command implements \CASS\Application\Command\Command
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