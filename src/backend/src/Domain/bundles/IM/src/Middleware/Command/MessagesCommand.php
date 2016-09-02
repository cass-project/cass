<?php
namespace CASS\Domain\Bundles\IM\Middleware\Command;

use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use CASS\Domain\Bundles\IM\Entity\Message;
use CASS\Domain\Bundles\IM\Exception\Query\QueryException;
use CASS\Domain\Bundles\IM\Middleware\Request\MessagesRequest;
use CASS\Domain\Bundles\Profile\Exception\ProfileNotFoundException;
use MongoDB\Model\BSONDocument;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class MessagesCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            $profile = $this->currentAccountService->getCurrentAccount()->getProfileWithId($request->getAttribute('targetProfileId'));
            $source = $this->sourceFactory->createSource(
                $request->getAttribute('source'),
                (int) $request->getAttribute('sourceId'),
                $profile->getId()
            );

            $query = $this->queryFactory->createQueryFromJSON($source, (new MessagesRequest($request))->getParameters());

            $messages = $this->imService->getMessages($query);
            
            $responseBuilder
                ->setStatusSuccess()
                ->setJson([
                    'source' => [
                        'code' => $source->getCode(),
                        'entity' => $this->sourceEntityLookupService->getEntityForSource($source)->toJSON()
                    ],
                    'messages' => array_map(function(Message $message) {
                        return $this->messageFormatter->format($message->toJSON());
                    }, $messages)
                ]);
        }catch(QueryException $e) {
            $responseBuilder
                ->setStatusBadRequest()
                ->setError($e);
        }catch(ProfileNotFoundException $e) {
            $responseBuilder
                ->setStatusNotAllowed()
                ->setError($e);
        }

        return $responseBuilder->build();
    }
}