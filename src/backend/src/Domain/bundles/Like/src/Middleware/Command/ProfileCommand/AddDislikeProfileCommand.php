<?php

namespace CASS\Domain\Bundles\Like\Middleware\Command\ProfileCommand;

use CASS\Domain\Bundles\Like\Entity\AttitudeFactory;
use CASS\Domain\Bundles\Like\Exception\AttitudeAlreadyExistsException;
use CASS\Domain\Bundles\Profile\Exception\ProfileNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;

class AddDislikeProfileCommand extends ProfileCommand
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            $profileId = $request->getAttribute('profileId');
            $profile = $this->profileService->getProfileById($profileId);

            $attitudeFactory = new AttitudeFactory($this->currentIPService->getCurrentIP(), $this->currentAccountService);
            $attitude = $attitudeFactory->getAttitude();
            $attitude->setResource($profile);

            $this->likeProfileService->addDislike($profile, $attitude);

            $responseBuilder
                ->setStatusSuccess()
                ->setJson([
                    'success' => true,
                    'entity' => $profile->toJSON(),
                ]);
        } catch(AttitudeAlreadyExistsException $e) {
            $responseBuilder
                ->setError($e)
                ->setJson(['success' => false])
                ->setStatusConflict();
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