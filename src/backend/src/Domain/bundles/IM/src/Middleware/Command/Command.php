<?php
namespace Domain\IM\Middleware\Command;

use Domain\Auth\Service\CurrentAccountService;
use Domain\IM\Formatter\MessageFormatter;
use Domain\IM\Query\QueryFactory;
use Domain\IM\Query\Source\SourceFactory;
use Domain\IM\Service\SourceEntityLookupService;
use Domain\Profile\Service\WithProfileService;
use Domain\ProfileIM\Service\IMService;

abstract class Command implements \Application\Command\Command
{
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

    /** @var WithProfileService */
    protected $withProfileService;

    public function __construct(
        QueryFactory $queryFactory,
        IMService $imService,
        MessageFormatter $messageFormatter,
        SourceFactory $sourceFactory,
        SourceEntityLookupService $sourceEntityLookupService,
        WithProfileService $withProfileService
    ) {
        $this->queryFactory = $queryFactory;
        $this->imService = $imService;
        $this->messageFormatter = $messageFormatter;
        $this->sourceFactory = $sourceFactory;
        $this->sourceEntityLookupService = $sourceEntityLookupService;
        $this->withProfileService = $withProfileService;
    }
}