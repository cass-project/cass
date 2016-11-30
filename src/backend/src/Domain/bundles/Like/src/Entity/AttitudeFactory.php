<?php

namespace CASS\Domain\Bundles\Like\Entity;

use CASS\Domain\Bundles\Auth\Service\CurrentAccountService;
use CASS\Domain\Bundles\Profile\Entity\Profile;
use Psr\Http\Message\ServerRequestInterface;

class AttitudeFactory
{
    protected $currentAccountService;
    protected $request;

    public function __construct(ServerRequestInterface $request, CurrentAccountService $currentAccountService)
    {
        $this->currentAccountService = $currentAccountService;
        $this->request = $request;
    }

    public function getAttitude(): Attitude
    {
        return  $this->currentAccountService->isAvailable()
            ?
            $this->profileAttitudeFactory($this->currentAccountService->getCurrentAccount()->getCurrentProfile())
            :
            $this->anonymousAttitudeFactory($this->request->getServerParams()['REMOTE_ADDR']);
    }

    static public function anonymousAttitudeFactory(string $ipAddress): Attitude
    {
        return (new Attitude())
            ->setIpAddress($ipAddress)
            ->setAttitudeOwnerType(Attitude::ATTITUDE_OWNER_TYPE_ANONYMOUS);
    }

    static public function profileAttitudeFactory(Profile $profile): Attitude
    {
        return (new Attitude)
            ->setProfileId($profile->getId())
            ->setAttitudeOwnerType(Attitude::ATTITUDE_OWNER_TYPE_PROFILE);
    }
}