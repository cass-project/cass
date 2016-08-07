<?php
namespace Domain\ProfileCommunities\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Domain\Profile\Exception\ProfileNotFoundException;
use Domain\ProfileCommunities\Exception\AlreadyJoinedException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class JoinCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            $profileId = $request->getAttribute('profileId');
            $communitySID = $request->getAttribute('communitySID');

            $eq = $this->profileCommunitiesService->joinToCommunity(
                $this->currentAccountService->getCurrentAccount()->getProfileWithId($profileId)->getId(),
                $communitySID
            );

            $responseBuilder
                ->setStatusSuccess()
                ->setJson([
                    'entity' => $eq->toJSON()
                ]);
        }catch(AlreadyJoinedException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusConflict();
        }catch(ProfileNotFoundException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusNotAllowed();
        }

        return $responseBuilder->build();
    }
}