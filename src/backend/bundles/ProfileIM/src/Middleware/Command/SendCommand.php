<?php
namespace ProfileIM\Middleware\Command;

use ProfileIM\Entity\ProfileMessage;
use ProfileIM\Middleware\Request\SendMessageRequest;
use Psr\Http\Message\ServerRequestInterface;

class SendCommand extends Command
{
    public function run(ServerRequestInterface $request)
    {
        $sourceProfile = $this->currentAccountService->getCurrentProfile();
        $targetProfile = $this->profileService->getProfileById(
          $request->getAttribute('targetProfileId')
        );

        $message = new ProfileMessage($sourceProfile, $targetProfile);

        $body = json_decode($request->getBody(), true);
        $message->setContent($body['content']);

        $this->profileIMService->createMessage($message);

        return [
            'message' => $message->toJSON()
        ];
    }
}