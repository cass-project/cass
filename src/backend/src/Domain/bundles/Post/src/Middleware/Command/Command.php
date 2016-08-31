<?php
namespace Domain\Post\Middleware\Command;

use Domain\Auth\Service\CurrentAccountService;
use Domain\Post\Formatter\PostFormatter;
use Domain\Post\Service\PostService;

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