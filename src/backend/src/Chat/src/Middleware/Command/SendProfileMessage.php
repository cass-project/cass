<?php

namespace CASS\Chat\Middleware\Command;

use Psr\Http\Message\ServerRequestInterface;
use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use Zend\Stratigility\Http\ResponseInterface;

class SendProfileMessage extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $profile = $this->currentAccountService->getCurrentAccount()->getCurrentProfile();

        $body = $request->getBody();

        print_r($body);
        die();
        $targetProfleId = (int) $body['profile_id'];
        $targetProfle = $this->profileService->getProfileById($targetProfleId);

        try {

            $message = new Message();
            $message
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