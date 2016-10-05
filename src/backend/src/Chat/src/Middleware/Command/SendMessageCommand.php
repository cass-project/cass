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
        $profile = $this->currentAccountService->getCurrentAccount()->getCurrentProfile();

        $targetProfle = $this->profileService->getProfileById($request->getAttribute('profileId'));

        try {

            $message = new Message();
            $message->setSourceProfile($profile);
            $message->setTargetProfile($targetProfle);

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