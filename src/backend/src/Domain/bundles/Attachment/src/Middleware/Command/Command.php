<?php
namespace CASS\Domain\Bundles\Attachment\Middleware\Command;

use CASS\Domain\Bundles\Auth\Service\CurrentAccountService;
use CASS\Domain\Bundles\Attachment\Service\FetchResourceService;
use CASS\Domain\Bundles\Attachment\Service\AttachmentService;

abstract class Command implements \CASS\Application\Command\Command
{
    /** @var CurrentAccountService */
    protected $currentAccountService;

    /** @var AttachmentService */
    protected $attachmentService;

    /** @var FetchResourceService */
    protected $fetchResourceService;

    public function __construct(
        CurrentAccountService $currentAccountService,
        AttachmentService $attachmentService,
        FetchResourceService $fetchResourceService
    )
    {
        $this->currentAccountService = $currentAccountService;
        $this->attachmentService = $attachmentService;
        $this->fetchResourceService = $fetchResourceService;
    }
}