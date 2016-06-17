<?php
namespace Domain\Profile\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Domain\Profile\Exception\ProfileNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface {

        try {
            $profileId = $this->validateProfileId($request->getAttribute('profileId'));
            $profile = $this->profileService->getProfileById($profileId);

            return $responseBuilder
                ->setStatusSuccess()
                ->setJson($this->profileExtendedFormatter->format($profile))
                ->build();
        }catch(ProfileNotFoundException $e){
            return $responseBuilder
                ->setStatusNotFound()
                ->build();
        }
    }
}