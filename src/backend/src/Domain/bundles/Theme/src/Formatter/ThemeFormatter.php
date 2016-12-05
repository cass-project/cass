<?php
namespace CASS\Domain\Bundles\Theme\Formatter;

use CASS\Domain\Bundles\Auth\Service\CurrentAccountService;
use CASS\Domain\Bundles\Like\Entity\Attitude;
use CASS\Domain\Bundles\Like\Entity\AttitudeFactory;
use CASS\Domain\Bundles\Like\Service\LikeThemeService;
use CASS\Domain\Bundles\Subscribe\Entity\Subscribe;
use CASS\Domain\Bundles\Subscribe\Service\SubscribeService;
use CASS\Domain\Bundles\Theme\Entity\Theme;
use CASS\Domain\Service\CurrentIPService\CurrentIPServiceInterface;

final class ThemeFormatter
{
    /** @var CurrentAccountService */
    private $currentAccountService;

    /** @var SubscribeService */
    private $subscribeService;

    /** @var LikeThemeService  */
    private $likeThemeService;

    /** @var CurrentIPServiceInterface  */
    private $currentIPService;

    public function __construct(
        CurrentAccountService $currentAccountService,
        SubscribeService $subscribeService,
        LikeThemeService $likeThemeService,
        CurrentIPServiceInterface $currentIPService
    ) {
        $this->currentAccountService = $currentAccountService;
        $this->subscribeService = $subscribeService;
        $this->likeThemeService = $likeThemeService;
        $this->currentIPService = $currentIPService;
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

        $attitudeFactory = new AttitudeFactory($this->currentIPService->getCurrentIP(), $this->currentAccountService);
        $attitude = $attitudeFactory->getAttitude();
        $attitude->setResource($theme);

        $attitudeState = 'none';
        if($this->likeThemeService->isAttitudeExists($attitude)) {
            $attitude = $this->likeThemeService->getAttitude($attitude);
            $attitudeState = $attitude->getAttitudeType() === Attitude::ATTITUDE_TYPE_LIKE ? 'liked' : 'disliked';
        }

        return array_merge($theme->toJSON(), [
            'subscribed' => $isSubscribedTo,
            'attitude' => [
                'state' => $attitudeState,
                'likes' => $theme->getLikes(),
                'dislikes' => $theme->getDislikes(),
            ],
        ]);
    }
}