<?php
namespace CASS\Chat\Middleware\Command;

use CASS\Chat\Entity\Message;
use CASS\Domain\Bundles\Profile\Exception\ProfileNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;

class SendMessageCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {

//        $profile = $this->currentAccountService->getCurrentAccount()->getCurrentProfile();

        $body = $request->getBody();
        $targetProfleId = (int) $body['profile_id'];
        $targetProfle = $this->profileService->getProfileById($targetProfleId);





        try {

            $message = new Message();
            $message
                ->setSourceId($profile->getId())
                ->setSourceType(Message::SOURCE_TYPE_PROFILE)
                ->setTargetId($targetProfle->getId())
                ->setTargetType(Message::TARGET_TYPE_PROFILE)
                ->setContent($content)
            ;


            $message = $this->messageService->createMessage($message);

            if($message)
                return $responseBuilder
                    ->setStatusSuccess()
                    ->setJson(['success' => true])
                ->build();
            
        }catch(ProfileNotFoundException $e){
            return $responseBuilder
                ->setStatusNotFound()
                ->setError($e)
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