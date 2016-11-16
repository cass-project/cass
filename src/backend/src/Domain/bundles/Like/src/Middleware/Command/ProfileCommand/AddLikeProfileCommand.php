<?php

namespace CASS\Domain\Bundles\Like\Middleware\Command\ProfileCommand;

use CASS\Domain\Bundles\Like\Entity\Attitude;
use CASS\Domain\Bundles\Profile\Exception\ProfileNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;

class AddLikeProfileCommand extends ProfileCommand
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
            $attitude->setAttitudeType(Attitude::ATTITUDE_TYPE_LIKE);
            $attitude->setResourceId($profile->getId())
                ->setResourceType(Attitude::RESOURCE_TYPE_PROFILE);


            $this->likeProfileService->addLike($profile, $attitude);


            // сохраняем в базе лог
            $profile->increaseLikes();


            // сохраняем сущность
            $this->profileService->saveProfile($profile);

            $responseBuilder
                ->setStatusSuccess()
                ->setJson(
                    [
                        'success' => TRUE,
                        'entity' => $profile->toJSON()
                    ]
                );

        } catch(ProfileNotFoundException $e){
            $responseBuilder
                ->setError($e)
                ->setJson(['success'=> false])
                ->setStatusNotFound();
        } catch(\Exception $e){
            $responseBuilder
                ->setError($e)
                ->setJson(['success'=> false])
                ->setStatusNotFound();
        }

        return $responseBuilder->build();
    }

}