<?php
namespace Domain\PostAttachment\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Domain\PostAttachment\Exception\InvalidURLException;
use Domain\PostAttachment\Exception\NotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class LinkCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            $entity = $this->postAttachmentService->linkAttachment($request->getQueryParams()['url'] ?? '');

            $responseBuilder
                ->setStatusSuccess()
                ->setJson([
                    'entity' => $entity->toJSON()
                ]);
        }catch(InvalidURLException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusBadRequest();
        }catch(NotFoundException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusNotFound();
        }

        return $responseBuilder->build();
    }
}