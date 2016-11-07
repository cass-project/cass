<?php
namespace CASS\Domain\Bundles\Subscribe\Middleware\Command;

use CASS\Domain\Bundles\Community\Exception\CommunityNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;

class SubscribeCommunityCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $currentProfile = $this->currentAccountService->getCurrentAccount()->getCurrentProfile();

        try {
            $community = $this->communityService->getCommunityById($request->getAttribute('communityId'));

            $entity = $this->subscribeService->subscribeCommunity($currentProfile, $community);

            $responseBuilder
                ->setJson([
                    'subscribe' => $this->subscribeFormatter->formatSingle($entity),
                ])
                ->setStatusSuccess();
        } catch (CommunityNotFoundException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusNotFound();
        }

        return $responseBuilder->build();
    }
}