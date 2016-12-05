<?php
namespace CASS\Domain\Bundles\Profile\Formatter;

use CASS\Domain\Bundles\Auth\Service\CurrentAccountService;
use CASS\Domain\Bundles\Like\Entity\Attitude;
use CASS\Domain\Bundles\Like\Entity\AttitudeFactory;
use CASS\Domain\Bundles\Like\Service\LikeProfileService;
use CASS\Domain\Bundles\Profile\Entity\Profile;
use CASS\Domain\Bundles\Subscribe\Entity\Subscribe;
use CASS\Domain\Bundles\Subscribe\Service\SubscribeService;
use CASS\Domain\Service\CurrentIPService\CurrentIPServiceInterface;

final class ProfileFormatter
{
    /** @var CurrentAccountService */
    private $currentAccountService;

    /** @var SubscribeService */
    private $subscribeService;

    /** @var LikeProfileService  */
    private $likeProfileService;

    /** @var CurrentIPServiceInterface  */
    private $currentIPService;

    public function __construct(
        CurrentAccountService $currentAccountService,
        SubscribeService $subscribeService,
        LikeProfileService $likeProfileService,
        CurrentIPServiceInterface $currentIPService
    ) {
        $this->currentAccountService = $currentAccountService;
        $this->subscribeService = $subscribeService;
        $this->likeProfileService = $likeProfileService;
        $this->currentIPService = $currentIPService;
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

        $attitudeFactory = new AttitudeFactory($this->currentIPService->getCurrentIP(), $this->currentAccountService);
        $attitude = $attitudeFactory->getAttitude();
        $attitude->setResource($profile);

        $attitudeState = 'none';
        if($this->likeProfileService->isAttitudeExists($attitude)) {
            $attitude = $this->likeProfileService->getAttitude($attitude);
            $attitudeState = $attitude->getAttitudeType() === Attitude::ATTITUDE_TYPE_LIKE ? 'liked' : 'disliked';
        }

        return array_merge($profile->toJSON(), [
            'subscribed' => $isSubscribedTo,
            'attitude' => [
                'state' => $attitudeState,
                'likes' => $profile->getLikes(),
                'dislikes' => $profile->getDislikes(),
            ],
        ]);
    }
}