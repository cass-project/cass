<?php
namespace CASS\Domain\Bundles\Subscribe\Middleware\Command;

use CASS\Domain\Bundles\Community\Exception\CommunityNotFoundException;
use CASS\Domain\Bundles\Subscribe\Exception\ConflictSubscribe;
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
        } catch (ConflictSubscribe $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusConflict();
        } catch (CommunityNotFoundException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusNotFound();
        }

        return $responseBuilder->build();
    }
}