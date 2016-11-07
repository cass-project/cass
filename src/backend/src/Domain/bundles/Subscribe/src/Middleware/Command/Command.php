<?php
namespace CASS\Domain\Bundles\Subscribe\Middleware\Command;

use CASS\Domain\Bundles\Auth\Service\CurrentAccountService;
use CASS\Domain\Bundles\Collection\Service\CollectionService;
use CASS\Domain\Bundles\Community\Service\CommunityService;
use CASS\Domain\Bundles\Profile\Service\ProfileService;
use CASS\Domain\Bundles\Subscribe\Formatter\SubscribeFormatter;
use CASS\Domain\Bundles\Subscribe\Service\SubscribeService;
use CASS\Domain\Bundles\Theme\Service\ThemeService;

abstract class Command implements \CASS\Application\Command\Command
{
    /** @var SubscribeService  */
    protected $subscribeService;

    /** @var CurrentAccountService  */
    protected $currentAccountService;

    /** @var ThemeService  */
    protected $themeService;

    /** @var ProfileService  */
    protected $profileService;

    /** @var CommunityService  */
    protected $communityService;

    /** @var CollectionService  */
    protected $collectionService;

    /** @var SubscribeFormatter */
    protected $subscribeFormatter;

    public function __construct(
        SubscribeService $subscribeService,
        CurrentAccountService $currentAccountService,
        ThemeService $themeService,
        ProfileService $profileService,
        CollectionService $collectionService,
        CommunityService $communityService,
        SubscribeFormatter $subscribeFormatter
    ){
        $this->themeService = $themeService;
        $this->subscribeService = $subscribeService;
        $this->currentAccountService = $currentAccountService;
        $this->profileService = $profileService;
        $this->collectionService = $collectionService;
        $this->communityService = $communityService;
        $this->subscribeFormatter = $subscribeFormatter;
    }
}