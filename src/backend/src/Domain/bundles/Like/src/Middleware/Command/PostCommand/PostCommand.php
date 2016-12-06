<?php
namespace CASS\Domain\Bundles\Like\Middleware\Command\PostCommand;

use CASS\Domain\Bundles\Auth\Service\CurrentAccountService;
use CASS\Domain\Bundles\Like\Middleware\Command\Command;
use CASS\Domain\Bundles\Like\Service\LikePostService;
use CASS\Domain\Bundles\Post\Formatter\PostFormatter;
use CASS\Domain\Bundles\Post\Service\PostService;
use CASS\Domain\Service\CurrentIPService\CurrentIPServiceInterface;

abstract class PostCommand extends Command
{
    protected $postService;
    protected $likePostService;
    protected $currentIPService;
    protected $postFormatter;

    public function __construct(
        CurrentAccountService $currentAccountService,
        PostService $postService,
        LikePostService $likePostService,
        CurrentIPServiceInterface $currentIPService,
        PostFormatter $postFormatter
    ){
        parent::__construct($currentAccountService);
        $this->postService = $postService;
        $this->likePostService = $likePostService;
        $this->currentIPService = $currentIPService;
        $this->postFormatter = $postFormatter;
    }
}