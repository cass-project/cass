<?php
namespace CASS\Domain\Bundles\ProfileCommunities\Middleware\Command;

use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use CASS\Domain\Bundles\ProfileCommunities\Exception\AlreadyLeavedException;
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