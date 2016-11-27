<?php
namespace CASS\Domain\Bundles\Feed\Middleware\Command\PersonalFeeds;

use CASS\Domain\Bundles\Feed\Middleware\Command\AbstractCommand;
use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class PersonalThemesCommand extends AbstractCommand
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $source = $this->sourceFactory->getPersonalThemesSource(
            $this->currentAccountService->getCurrentAccount()->getCurrentProfile()->getId()
        );

        return $this->makeFeed($source, $request, $responseBuilder);
    }
}
