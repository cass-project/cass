<?php
namespace CASS\Domain\Bundles\Community\Formatter;

use CASS\Domain\Bundles\Auth\Service\CurrentAccountService;
use CASS\Domain\Bundles\Community\Entity\Community;
use CASS\Domain\Bundles\Like\Entity\Attitude;
use CASS\Domain\Bundles\Like\Entity\AttitudeFactory;
use CASS\Domain\Bundles\Like\Service\LikeCommunityService;
use CASS\Domain\Service\CurrentIPService\CurrentIPServiceInterface;

final class CommunityFormatter
{
    private $currentAccountService;
    private $likeCommunityService;
    private $currentIPService;

    public function __construct(
        CurrentAccountService $currentAccountService,
        LikeCommunityService $likeCommunityService,
        CurrentIPServiceInterface $currentIPService
    ){
        $this->currentAccountService = $currentAccountService;
        $this->likeCommunityService = $likeCommunityService;
        $this->currentIPService = $currentIPService;
    }

    public function formatMany(array $communities): array
    {
        return array_map(function(Community $community) {
            return $community->toJSON();
        }, $communities);
    }

    public function formatOne(Community $community): array
    {
        $attitudeFactory = new AttitudeFactory($this->currentIPService->getCurrentIP(), $this->currentAccountService);
        $attitude = $attitudeFactory->getAttitude();
        $attitude->setResource($community);

        $attitudeState = 'none';
        if($this->likeCommunityService->isAttitudeExists($attitude)) {
            $attitude = $this->likeCommunityService->getAttitude($attitude);
            $attitudeState = $attitude->getAttitudeType() === Attitude::ATTITUDE_TYPE_LIKE ? 'liked' : 'disliked';
        }

        return array_merge($community->toJSON(),[
            'attitude' => [
                'state' => $attitudeState,
                'likes' => $community->getLikes(),
                'dislikes' => $community->getDislikes(),
            ],
        ]);
    }
}