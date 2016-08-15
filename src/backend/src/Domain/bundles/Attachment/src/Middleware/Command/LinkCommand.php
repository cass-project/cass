<?php
namespace Domain\Attachment\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Domain\Attachment\Exception\InvalidURLException;
use Domain\Attachment\Exception\NotFoundException;
use Domain\Attachment\Source\ExternalSource;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class LinkCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            $url = $request->getQueryParams()['url'] ?? '';
            $source = new ExternalSource($url);

            if(strpos($url, 'http') === false) {
                $url = 'http://' . $url;
            }

            $result = $this->fetchResourceService->fetchResource($url);
            $entity = $this->attachmentService->linkAttachment($url, $result, $source);

            $responseBuilder
                ->setStatusSuccess()
                ->setJson([
                    'entity' => $entity->toJSON(),
                ]);
        } catch(InvalidURLException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusBadRequest();
        } catch(NotFoundException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusNotFound();
        }

        return $responseBuilder->build();
    }
}