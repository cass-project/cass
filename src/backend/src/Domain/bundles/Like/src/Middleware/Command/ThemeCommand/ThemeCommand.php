<?php

namespace CASS\Domain\Bundles\Like\Middleware\Command\ThemeCommand;

use CASS\Domain\Bundles\Auth\Service\CurrentAccountService;
use CASS\Domain\Bundles\Like\Middleware\Command\Command;
use CASS\Domain\Bundles\Like\Service\LikeThemeService;
use CASS\Domain\Bundles\Theme\Service\ThemeService;
use CASS\Domain\Service\CurrentIPService\CurrentIPServiceInterface;

abstract class ThemeCommand extends Command
{
    /** @var LikeThemeService  */
    protected $likeThemeService;
    /** @var ThemeService  */
    protected $themeService;

    /** @var CurrentIPServiceInterface  */
    protected $currentIPService;

    public function __construct(
        CurrentAccountService $currentAccountService,
        LikeThemeService $likeThemeService,
        ThemeService $themeService,
        CurrentIPServiceInterface  $currentIPService
    ){
        parent::__construct( $currentAccountService);
        $this->likeThemeService = $likeThemeService;
        $this->themeService = $themeService;
        $this->currentIPService = $currentIPService;
    }
}