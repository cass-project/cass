<?php
namespace Domain\IM\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Domain\IM\Entity\ProfileMessage;
use Domain\IM\Exception\SameTargetAndSourceException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class SendCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $sourceProfile = $this->currentAccountService->getCurrentProfile();
        $targetProfile = $this->profileService->getProfileById(
            $request->getAttribute('targetProfileId')
        );

        if($sourceProfile->getId() == $targetProfile->getId()) {
            throw new SameTargetAndSourceException("Source profile must not be same as target profile");
        }

        $message = new ProfileMessage($sourceProfile, $targetProfile);

        if($request->getParsedBody()) {
            $body = $request->getParsedBody();
        } else {
            $body = json_decode($request->getBody());
        }

        $message->setContent($body->content);

        $this->profileIMService->createMessage($message);

        return $responseBuilder
            ->setStatusSuccess()
            ->setJson([
                'message' => $message->toJSON()
            ])
            ->build();
    }
}