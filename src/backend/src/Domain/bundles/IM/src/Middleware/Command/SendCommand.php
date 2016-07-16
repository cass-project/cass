<?php
namespace Domain\IM\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Domain\Community\Exception\CommunityNotFoundException;
use Domain\IM\Entity\Message;
use Domain\IM\Middleware\Request\SendMessageRequest;
use Domain\Profile\Exception\ProfileNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class SendCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        try {
            $author = $this->withProfileService->getProfile();
            $source = $this->sourceFactory->createSource(
                $request->getAttribute('source'),
                (int) $request->getAttribute('sourceId'),
                $author->getId()
            );

            $parameters = (new SendMessageRequest($request))->getParameters();

            $message = new Message(
                $author,
                $parameters->getMessage(),
                $parameters->getAttachmentIds()
            );

            $this->imService->sendMessage($source, $message);

            $responseBuilder
                ->setStatusSuccess()
                ->setJson([
                    'entity' => $this->messageFormatter->format($message->toMongoBSON())
                ]);
        }catch(ProfileNotFoundException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusNotFound();
        }catch(CommunityNotFoundException $e) {
            $responseBuilder
                ->setError($e)
                ->setStatusNotFound();
        }

        return $responseBuilder->build();
    }
}