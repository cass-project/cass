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

            $responseBuilder
                ->setStatusSuccess();
        } catch (ProfileNotFoundException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusNotFound();
        }

        return $responseBuilder->build();
    }
}