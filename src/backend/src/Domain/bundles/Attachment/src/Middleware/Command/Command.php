<?php
namespace CASS\Domain\Attachment\Middleware\Command;

use CASS\Domain\Auth\Service\CurrentAccountService;
use CASS\Domain\Attachment\Service\FetchResourceService;
use CASS\Domain\Attachment\Service\AttachmentService;

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