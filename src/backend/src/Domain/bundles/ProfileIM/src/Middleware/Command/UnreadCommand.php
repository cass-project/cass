<?php
namespace Domain\ProfileIM\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Domain\ProfileIM\Entity\ProfileMessage;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UnreadCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $profile_id = $this->currentAccountService->getCurrentProfile()->getId();
        $messages = $this->profileIMService->getUnreadMessagesByProfileId($profile_id);

        $unread_messages = [];
        foreach($messages as $message) {
            if($message instanceof ProfileMessage) {
                $source_profile_id = $message->getSourceProfile()->getId();
                $unread_messages[$source_profile_id]['source_profile'] = $message->getSourceProfile()->toJSON();
            }
        }

        foreach($unread_messages as $source_profile_id => &$unread_message) {
            $sum_messages = 0;
            foreach($messages as $message) {
                if($message instanceof ProfileMessage) {
                    if($source_profile_id === $message->getSourceProfile()->getId()) {
                        $sum_messages++;
                    }
                }
            }
            $unread_message['total'] = $sum_messages;
        }

        return $responseBuilder
            ->setStatusSuccess()
            ->setJson([
                'unread' => $unread_messages
            ])
            ->build();
    }
}