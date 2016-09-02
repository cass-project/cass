<?php
namespace CASS\Domain\Bundles\Attachment\Middleware\Command;

use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use CASS\Domain\Bundles\Attachment\Exception\InvalidURLException;
use CASS\Domain\Bundles\Attachment\Exception\NotFoundException;
use CASS\Domain\Bundles\Attachment\Source\ExternalSource;
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