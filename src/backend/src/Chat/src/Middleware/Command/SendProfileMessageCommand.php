<?php

namespace CASS\Chat\Middleware\Command;

use CASS\Chat\Entity\Message;
use CASS\Domain\Bundles\Profile\Exception\ProfileNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;

class SendProfileMessageCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $body = json_decode($request->getBody()->getContents(), true);
        $content = $body['content'];

        $sourceProfile = $this->currentAccountService->getCurrentAccount()->getCurrentProfile();
        $targetProfileId = $request->getAttribute('profileId');

        try {
            $targetProfile = $this->profileService->getProfileById($targetProfileId);

            $message = new Message();
            $message
                ->setSourceType(Message::SOURCE_TYPE_PROFILE)
                ->setSourceId($sourceProfile->getId())
                ->setTargetType(Message::TARGET_TYPE_PROFILE)
                ->setTargetId($targetProfile->getId())
                ->setContent($content)
            ;

            $message2 = $this->messageService->createMessage($message);
            if($message)
                return $responseBuilder
                    ->setStatusSuccess()
                    ->setJson([
                        'success' => true,
                        'entity' => $message2->toJSON()
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
                ->setError($e)
                ->setJson(['success' => false])
                ->build();
        }
    }

}