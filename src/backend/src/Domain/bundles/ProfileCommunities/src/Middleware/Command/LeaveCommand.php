<?php
namespace Domain\ProfileCommunities\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Domain\ProfileCommunities\Exception\AlreadyLeavedException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class LeaveCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            $profileId = $request->getAttribute('profileId');
            $communitySID = $request->getAttribute('communitySID');

            $this->profileCommunitiesService->leaveCommunity(
                $this->currentAccountService->getCurrentAccount()->getProfileWithId($profileId)->getId(),
                $communitySID
            );

            $responseBuilder
                ->setStatusSuccess();
        }catch(AlreadyLeavedException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusConflict();
        }

        return $responseBuilder->build();
    }
}