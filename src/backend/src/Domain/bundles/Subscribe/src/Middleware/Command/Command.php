<?php
namespace CASS\Domain\Bundles\Subscribe\Middleware\Command;

use CASS\Domain\Bundles\Auth\Service\CurrentAccountService;
use CASS\Domain\Bundles\Subscribe\Service\SubscribeService;
use CASS\Domain\Bundles\Theme\Service\ThemeService;

abstract class Command implements \CASS\Application\Command\Command
{

    protected $subscribeService;

    protected $currentAccountService;

    protected $themeService;

    public function __construct(SubscribeService $subscribeService, CurrentAccountService $currentAccountService, ThemeService $themeService)
    {
        $this->themeService = $themeService;
        $this->subscribeService = $subscribeService;
        $this->currentAccountService = $currentAccountService;
    }
}