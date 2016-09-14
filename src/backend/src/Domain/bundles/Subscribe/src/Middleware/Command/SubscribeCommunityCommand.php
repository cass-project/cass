<?php
namespace CASS\Domain\Bundles\Subscribe\Middleware\Command;

use CASS\Application\Exception\BadCommandCallException;
use CASS\Domain\Bundles\Theme\Exception\ThemeNotFoundException;
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

            $this->subscribeService->subscribeCommunity($currentProfile, $community);

            return $responseBuilder
                ->setStatusSuccess()
                ->build();
        } catch (ThemeNotFoundException $e) {
            throw new BadCommandCallException($e->getMessage());
        }
    }
}