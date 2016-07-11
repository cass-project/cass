<?php
namespace Domain\PostAttachment\Middleware\Command;

use Domain\Auth\Service\CurrentAccountService;
use Domain\PostAttachment\Service\FetchResourceService;
use Domain\PostAttachment\Service\PostAttachmentService;

abstract class Command implements \Application\Command\Command
{
    /** @var CurrentAccountService */
    protected $currentAccountService;
    
    /** @var PostAttachmentService */
    protected $postAttachmentService;

    /** @var FetchResourceService */
    protected $fetchResourceService;

    public function __construct(
        CurrentAccountService $currentAccountService,
        PostAttachmentService $postAttachmentService,
        FetchResourceService $fetchResourceService
    ) {
        $this->currentAccountService = $currentAccountService;
        $this->postAttachmentService = $postAttachmentService;
        $this->fetchResourceService = $fetchResourceService;
    }
}