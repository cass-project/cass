<?php
namespace Domain\Attachment\Middleware\Command;

use Domain\Auth\Service\CurrentAccountService;
use Domain\Attachment\Service\FetchResourceService;
use Domain\Attachment\Service\AttachmentService;

abstract class Command implements \Application\Command\Command
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