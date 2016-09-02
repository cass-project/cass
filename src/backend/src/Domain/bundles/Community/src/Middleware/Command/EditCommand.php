<?php
namespace CASS\Domain\Community\Middleware\Command;

use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use CASS\Domain\Community\Exception\CommunityNotFoundException;
use CASS\Domain\Community\Middleware\Request\EditCommunityRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class EditCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            $editCommunityRequest = new EditCommunityRequest($request);
            $community = $this->communityService->editCommunity($request->getAttribute('communityId'), $editCommunityRequest->getParameters());

            $responseBuilder
                ->setStatusSuccess()
                ->setJson([
                    'entity' => $this->communityFormatter->format($community),
                ]);
        }catch(CommunityNotFoundException $e) {
            $responseBuilder
                ->setStatusNotFound()
                ->setError($e);
        }

        return $responseBuilder->build();
    }
}