<?php
namespace Domain\Collection\Middleware\Command;

use CASS\Application\REST\Response\ResponseBuilder;
use Domain\Collection\Exception\CollectionNotFoundException;
use Domain\Collection\Exception\InvalidCollectionOptionsException;
use Domain\Collection\Middleware\Request\SetPublicOptionsRequest;
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