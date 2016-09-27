<?php
namespace CASS\Domain\Bundles\Subscribe\Middleware\Command;

use CASS\Domain\Bundles\Profile\Exception\ProfileNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;

class UnSubscribeProfileCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $currentProfile = $this->currentAccountService->getCurrentAccount()->getCurrentProfile();

        try {
            $profile = $this->profileService->getProfileById($request->getAttribute('profileId'));

            $this->subscribeService->unSubscribeProfile($currentProfile, $profile);

            return $responseBuilder
                ->setStatusSuccess()
                ->build();
        } catch (ProfileNotFoundException $e) {
            return $responseBuilder
                ->setStatusNotFound()
                ->build();
        }
    }
}