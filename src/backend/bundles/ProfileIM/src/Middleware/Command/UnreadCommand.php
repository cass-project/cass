<?php
namespace ProfileIM\Middleware\Command;

use ProfileIM\Entity\ProfileMessage;
use Psr\Http\Message\ServerRequestInterface;

class UnreadCommand extends Command
{
    public function run(ServerRequestInterface $request)
    {
        $profile_id = $this->currentAccountService->getCurrentProfile()->getId();
        $messages = $this->profileIMService->getUnreadMessagesByProfileId( $profile_id);

        $unread_messages = [];
        foreach($messages as $message){
            if($message instanceof ProfileMessage){
                $source_profile_id = $message->getSourceProfile()->getId();
                $unread_messages[$source_profile_id]['source_profile'] = $message->getSourceProfile()->toJSON();
            }
        }

        foreach($unread_messages as $source_profile_id => &$unread_message){
            $sum_messages = 0;
            foreach($messages as $message){
                if($message instanceof ProfileMessage){
                    if($source_profile_id === $message->getSourceProfile()->getId()){
                        $sum_messages++;
                   }
                }
            }
            $unread_message['total'] = $sum_messages;
        }

        return ['unread' => $unread_messages];
    }
}