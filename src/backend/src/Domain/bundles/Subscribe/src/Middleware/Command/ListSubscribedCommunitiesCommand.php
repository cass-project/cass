<?php
namespace CASS\Domain\Bundles\Subscribe\Middleware\Command;

use CASS\Application\Exception\BadCommandCallException;
use CASS\Domain\Bundles\Theme\Exception\ThemeNotFoundException;
use CASS\Util\Seek;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;

class ListSubscribedCommunitiesCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $currentProfile = $this->currentAccountService->getCurrentAccount()->getCurrentProfile();

        try {
            $seek = new Seek(100, 0, 100);

            $this->subscribeService->listSubscribedCommunities($currentProfile, $seek);

            return $responseBuilder
                ->setStatusSuccess()
                ->build();
        } catch (ThemeNotFoundException $e) {
            throw new BadCommandCallException($e->getMessage());
        }
    }

}