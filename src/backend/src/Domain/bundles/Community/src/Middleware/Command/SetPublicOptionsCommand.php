<?php
namespace CASS\Domain\Bundles\Community\Middleware\Command;

use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use CASS\Domain\Bundles\Community\Exception\CommunityHasNoThemeException;
use CASS\Domain\Bundles\Community\Exception\CommunityNotFoundException;
use CASS\Domain\Bundles\Community\Middleware\Request\SetPublicOptionsRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class SetPublicOptionsCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            $parameters = (new SetPublicOptionsRequest($request))->getParameters();

            $this->communityService->setPublicOptions($request->getAttribute('communityId'), $parameters);

            $responseBuilder->setStatusSuccess();
        }catch(CommunityHasNoThemeException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusConflict();
        }catch(CommunityNotFoundException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusNotFound();
        }


        return $responseBuilder->build();
    }
}