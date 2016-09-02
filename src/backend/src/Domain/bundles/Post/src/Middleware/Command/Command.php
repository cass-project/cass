<?php
namespace CASS\Domain\Bundles\Post\Middleware\Command;

use CASS\Domain\Bundles\Auth\Service\CurrentAccountService;
use CASS\Domain\Bundles\Post\Formatter\PostFormatter;
use CASS\Domain\Bundles\Post\Service\PostService;

abstract class Command implements \CASS\Application\Command\Command
{
    /** @var PostService */
    protected $postService;

    /** @var CurrentAccountService */
    protected $currentProfileService;

    /** @var PostFormatter */
    protected $postFormatter;

    public function __construct(
        PostService $postService,
        CurrentAccountService $currentProfileService,
        PostFormatter $postFormatter
    ) {
        $this->postService = $postService;
        $this->currentProfileService = $currentProfileService;
        $this->postFormatter = $postFormatter;
    }
}