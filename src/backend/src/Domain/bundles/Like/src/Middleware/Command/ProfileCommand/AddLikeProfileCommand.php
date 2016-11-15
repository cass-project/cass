<?php

namespace CASS\Domain\Bundles\Like\Middleware\Command\ProfileCommand;

use CASS\Domain\Bundles\Like\Middleware\Command\Command;
use CASS\Domain\Bundles\Profile\Exception\ProfileNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;

class AddLikeProfileCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {

            $profileId = $request->getAttribute('profileId');
            $profile = $this->profileService->getProfileById($profileId);

            $profile->increaseLikes();

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