<?php

namespace CASS\Domain\Bundles\Like\Middleware\Command\ProfileCommand;

use CASS\Domain\Bundles\Like\Entity\Attitude;
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

            // устанавливаем владельца
            $attitude = $this->currentAccountService->isAvailable()
                ?
                Attitude::profileAttitudeFactory($this->currentAccountService->getCurrentAccount()->getCurrentProfile())
                :
                Attitude::anonymousAttitudeFactory($request->getServerParams()['REMOTE_ADDR']);

            // устанавливаем свойства
            $attitude->setResource($profile);

            $this->likeProfileService->addDislike($profile, $attitude);

            $responseBuilder
                ->setStatusSuccess()
                ->setJson(
                    [
                        'success' => true,
                        'entity' => $profile->toJSON(),
                    ]
                );
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