<?php
namespace CASS\Domain\Bundles\Profile\Formatter;

use CASS\Domain\Bundles\Auth\Service\CurrentAccountService;
use CASS\Domain\Bundles\Profile\Entity\Profile;
use CASS\Domain\Bundles\Subscribe\Entity\Subscribe;
use CASS\Domain\Bundles\Subscribe\Service\SubscribeService;

final class ProfileFormatter
{
    /** @var CurrentAccountService */
    private $currentAccountService;

    /** @var SubscribeService */
    private $subscribeService;

    public function __construct(
        CurrentAccountService $currentAccountService,
        SubscribeService $subscribeService
    ) {
        $this->currentAccountService = $currentAccountService;
        $this->subscribeService = $subscribeService;
    }

    public function formatMany(array $profiles)
    {
        return array_map(function(Profile $profile) {
            return $this->formatOne($profile);
        }, $profiles);
    }

    public function formatOne(Profile $profile)
    {
        $isSubscribedTo = $this->currentAccountService->isAvailable()
            ? $this->subscribeService->hasSubscribe(
                $this->currentAccountService->getCurrentAccount()->getCurrentProfile()->getId(),
                Subscribe::TYPE_PROFILE,
                $profile->getId())
            : false;

        return array_merge($profile->toJSON(), [
            'subscribed' => $isSubscribedTo
        ]);
    }
}