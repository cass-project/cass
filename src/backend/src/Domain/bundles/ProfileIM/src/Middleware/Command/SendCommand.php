<?php
namespace Domain\ProfileIM\Middleware\Command;

use Domain\ProfileIM\Entity\ProfileMessage;
use Domain\ProfileIM\Exception\SameTargetAndSourceException;
use Domain\ProfileIM\Middleware\Request\SendMessageRequest;
use Psr\Http\Message\ServerRequestInterface;

class SendCommand extends Command
{
    public function run(ServerRequestInterface $request)
    {
        $sourceProfile = $this->currentAccountService->getCurrentProfile();
        $targetProfile = $this->profileService->getProfileById(
          $request->getAttribute('targetProfileId')
        );

        if($sourceProfile->getId() == $targetProfile->getId()){
            throw new SameTargetAndSourceException("souurce profile must not be same as target profile");
        }

        $message = new ProfileMessage($sourceProfile, $targetProfile);

        $body = json_decode($request->getBody(), true);
        $message->setContent($body['content']);

        $this->profileIMService->createMessage($message);

        return [
            'message' => $message->toJSON()
        ];
    }
}