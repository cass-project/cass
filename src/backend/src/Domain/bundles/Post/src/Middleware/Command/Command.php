<?php
namespace Domain\Post\Middleware\Command;

use Domain\Auth\Service\CurrentAccountService;
use Domain\Post\Service\PostService;

abstract class Command implements \Application\Command\Command
{
    /** @var PostService */
    protected $postService;

    /** @var CurrentAccountService */
    protected $currentProfileService;

    public function __construct(
        PostService $postService,
        CurrentAccountService $currentProfileService
    ) {
        $this->postService = $postService;
        $this->currentProfileService = $currentProfileService;
    }
}