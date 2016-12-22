<?php

namespace CASS\Chat\Middleware\Command;

use CASS\Chat\Entity\Message;
use CASS\Chat\Repository\MessageRepository;
use CASS\Domain\Bundles\Profile\Exception\ProfileNotFoundException;
use CASS\Util\Seek;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;

class GetProfileMessagesCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $bodyJson = json_decode($request->getBody()->getContents(), true);

        $seek = new Seek(MessageRepository::MAX_MESSAGES_LIMIT, $bodyJson['offset'], $bodyJson['limit']);

        $sourceProfile = $this->currentAccountService->getCurrentAccount()->getCurrentProfile();
        $targetProfileId = $request->getAttribute('profileId');

        try {
            $targetProfile = $this->profileService->getProfileById($targetProfileId);
            $messages = $this->messageService->getMessagesToProfile($sourceProfile, $targetProfile, $seek);

            return $responseBuilder
                ->setStatusSuccess()
                ->setJson([
                    'success' => true,
                    'total' => count($messages),
                    'entities' => array_map(function(Message $message){
                        return $message->toJSON();
                    }, $messages),
                ])
                ->build();

        }catch(ProfileNotFoundException $e){
            return $responseBuilder
                ->setStatusNotFound()
                ->setError($e->getMessage())
                ->setJson(['success' => false])
                ->build();
        }catch(\Exception $e) {
            return $responseBuilder
                ->setStatusInternalError()
                ->setError($e->getMessage())
                ->setJson(['success' => false])
                ->build();
        }
    }

}