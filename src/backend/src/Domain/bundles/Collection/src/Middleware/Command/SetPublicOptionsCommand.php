<?php
namespace CASS\Domain\Bundles\Collection\Middleware\Command;

use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use CASS\Domain\Bundles\Collection\Exception\CollectionNotFoundException;
use CASS\Domain\Bundles\Collection\Exception\InvalidCollectionOptionsException;
use CASS\Domain\Bundles\Collection\Middleware\Request\SetPublicOptionsRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class SetPublicOptionsCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            $this->collectionService->setPublicOptions(
                $request->getAttribute('collectionId'),
                (new SetPublicOptionsRequest($request))->getParameters()
            );

            $responseBuilder->setStatusSuccess();
        } catch(InvalidCollectionOptionsException $e) {
            $responseBuilder
                ->setStatusConflict()
                ->setError($e);
        } catch(CollectionNotFoundException $e) {
            $responseBuilder
                ->setStatusNotFound()
                ->setError($e);
        }

        return $responseBuilder->build();
    }
}