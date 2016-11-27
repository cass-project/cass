<?php
namespace CASS\Domain\Bundles\Theme\Formatter;

use CASS\Domain\Bundles\Auth\Service\CurrentAccountService;
use CASS\Domain\Bundles\Subscribe\Entity\Subscribe;
use CASS\Domain\Bundles\Subscribe\Service\SubscribeService;
use CASS\Domain\Bundles\Theme\Entity\Theme;

final class ThemeFormatter
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

    public function formatMany(array $themes)
    {
        return array_map(function(Theme $theme) {
            return $this->formatOne($theme);
        }, $themes);
    }

    public function formatOne(Theme $theme)
    {
        $isSubscribedTo = $this->currentAccountService->isAvailable()
            ? $this->subscribeService->hasSubscribe(
                $this->currentAccountService->getCurrentAccount()->getCurrentProfile()->getId(),
                Subscribe::TYPE_THEME,
                $theme->getId())
            : false;

        return array_merge($theme->toJSON(), [
            'subscribed' => $isSubscribedTo
        ]);
    }
}