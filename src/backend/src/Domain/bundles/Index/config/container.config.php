<?php
namespace CASS\Domain\Bundles\Index;

use CASS\Domain\Bundles\Auth\Service\CurrentAccountService;
use CASS\Domain\Bundles\Index\Processor\Processors\PersonalFeeds\PersonalCollectionsProcessor;
use CASS\Domain\Bundles\Index\Processor\Processors\PersonalFeeds\PersonalCommunitiesProcessor;
use CASS\Domain\Bundles\Index\Processor\Processors\PersonalFeeds\PersonalPeopleProcessor;
use CASS\Domain\Bundles\Index\Processor\Processors\PersonalFeeds\PersonalThemesProcessor;
use CASS\Domain\Bundles\Subscribe\Service\SubscribeService;
use function DI\object;
use function DI\factory;
use function DI\get;

return [
    'php-di' => [
        PersonalPeopleProcessor::class => object()
            ->method('setCurrentAccountService', get(CurrentAccountService::class))
            ->method('setSubscriptionService', get(SubscribeService::class)),
        PersonalCollectionsProcessor::class => object()->method('setCurrentAccountService', get(CurrentAccountService::class))
            ->method('setCurrentAccountService', get(CurrentAccountService::class))
            ->method('setSubscriptionService', get(SubscribeService::class)),
        PersonalCommunitiesProcessor::class => object()->method('setCurrentAccountService', get(CurrentAccountService::class))
            ->method('setCurrentAccountService', get(CurrentAccountService::class))
            ->method('setSubscriptionService', get(SubscribeService::class)),
        PersonalThemesProcessor::class => object()->method('setCurrentAccountService', get(CurrentAccountService::class))
            ->method('setCurrentAccountService', get(CurrentAccountService::class))
            ->method('setSubscriptionService', get(SubscribeService::class)),
    ]
];