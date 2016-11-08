<?php
namespace CASS\Domain\Bundles\Subscribe\Middleware\Command;

use CASS\Domain\Bundles\Community\Exception\CommunityNotFoundException;
use CASS\Domain\Bundles\Subscribe\Exception\UnknownSubscribeException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;

class UnSubscribeCommunityCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $currentProfile = $this->currentAccountService->getCurrentAccount()->getCurrentProfile();

        try {
            $community = $this->communityService->getCommunityById($request->getAttribute('communityId'));
            $this->subscribeService->unSubscribeCommunity($currentProfile, $community);

            $responseBuilder
                ->setStatusSuccess();
        } catch (UnknownSubscribeException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusNotFound();
        } catch (CommunityNotFoundException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusNotFound();
        }

        return $responseBuilder->build();
    }

}