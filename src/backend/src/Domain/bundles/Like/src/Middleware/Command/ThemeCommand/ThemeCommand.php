<?php

namespace CASS\Domain\Bundles\Like\Middleware\Command\ThemeCommand;

use CASS\Domain\Bundles\Auth\Service\CurrentAccountService;
use CASS\Domain\Bundles\Like\Middleware\Command\Command;
use CASS\Domain\Bundles\Like\Service\LikeThemeService;
use CASS\Domain\Bundles\Theme\Service\ThemeService;

abstract class ThemeCommand extends Command
{
    /** @var LikeThemeService  */
    protected $likeThemeService;
    /** @var ThemeService  */
    protected $themeService;

    public function __construct(
        CurrentAccountService $currentAccountService,
        LikeThemeService $likeThemeService,
        ThemeService $themeService
    ){
        parent::__construct( $currentAccountService);
        $this->likeThemeService = $likeThemeService;
        $this->themeService = $themeService;
    }
}