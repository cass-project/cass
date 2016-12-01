<?php

namespace CASS\Domain\Bundles\Like\Middleware\Command\ProfileCommand;

use CASS\Domain\Bundles\Like\Entity\Attitude;
use CASS\Domain\Bundles\Like\Entity\AttitudeFactory;
use CASS\Domain\Bundles\Like\Exception\AttitudeNotFoundException;
use CASS\Domain\Bundles\Profile\Exception\ProfileNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;

class RemoveProfileAttitude extends ProfileCommand
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            $profileId = $request->getAttribute('profileId');
            $profile = $this->profileService->getProfileById($profileId);

            // устанавливаем владельца
            $attitudeFactory = new AttitudeFactory($this->currentIPService->getCurrentIP(), $this->currentAccountService);
            $attitude = $attitudeFactory->getAttitude();
            $attitude->setResource($profile);


            // устанавливаем свойства
            $attitude->setResource($profile);
            $attitude = $this->likeProfileService->getAttitude($attitude);

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
                ->setJson(
                    [
                        'success' => true,
                        'entity' => $profile->toJSON(),
                    ]
                );

        } catch(AttitudeNotFoundException $e) {
            $responseBuilder
                ->setError($e)
                ->setJson(['success' => false])
                ->setStatusNotFound();
        } catch(ProfileNotFoundException $e) {
            $responseBuilder
                ->setError($e)
                ->setJson(['success' => false])
                ->setStatusNotFound();
        } catch(\Exception $e) {
            $responseBuilder
                ->setError($e)
                ->setJson(['success' => false])
                ->setStatusNotFound();
        }

        return $responseBuilder->build();
    }
}