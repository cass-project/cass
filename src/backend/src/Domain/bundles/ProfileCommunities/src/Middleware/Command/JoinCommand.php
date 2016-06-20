<?php
namespace Domain\ProfileCommunities\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Domain\ProfileCommunities\Exception\AlreadyJoinedException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class JoinCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            $communitySID = $request->getAttribute('communitySID');

            $eq = $this->profileCommunitiesService->joinToCommunity($communitySID);

            $responseBuilder
                ->setStatusSuccess()
                ->setJson([
                    'entity' => $eq->toJSON()
                ]);
        }catch(AlreadyJoinedException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusConflict();
        }

        return $responseBuilder->build();
    }

}