<?php

namespace CASS\Domain\Bundles\Like\Middleware\Command\ProfileCommand;

use CASS\Domain\Bundles\Like\Entity\Attitude;
use CASS\Domain\Bundles\Profile\Exception\ProfileNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;

class RemoveAttitude extends ProfileCommand
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            $profileId = $request->getAttribute('profileId');
            $profile = $this->profileService->getProfileById($profileId);

            // устанавливаем владельца
            $attitude = $this->currentAccountService->isAvailable()
                ?
                Attitude::profileAttitudeFactory($this->currentAccountService->getCurrentAccount()->getCurrentProfile())
                :
                Attitude::anonymousAttitudeFactory($request->getServerParams()['REMOTE_ADDR']);

            // устанавливаем свойства
            $attitude->setResource($profile);

            switch($attitude->getAttitudeType()) {
                case Attitude::ATTITUDE_TYPE_LIKE:
                    $this->likeProfileService->removeLike($profile, $attitude);
                    break;
                case Attitude::ATTITUDE_TYPE_DISLIKE:
                    $this->likeProfileService->removeDislike($profile, $attitude);
                    break;
            }

            $responseBuilder
                ->setStatusSuccess()
                ->setJson([
                    'success' => true,
                ]);

        } catch(ProfileNotFoundException $e) {
            $responseBuilder
                ->setError($e)
                ->setJson(['success' => false])
                ->setStatusNotFound();
        } catch(\Exception $e) {

        }

        return $responseBuilder->build();
    }

}