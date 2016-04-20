<?php
namespace ProfileIM\Middleware\Command;

use ProfileIM\Entity\ProfileMessage;
use Psr\Http\Message\ServerRequestInterface;

class MessagesCommand extends Command
{
  public function run(ServerRequestInterface $request){
    $sourceProfileId = $request->getAttribute('sourceProfileId');
    $offset          = $request->getAttribute('offset');
    $limit           = $request->getAttribute('limit');
    $markAsRead      = $request->getQueryParams()['markAsRead'];



    $criteria = [
      'source_profile' => $sourceProfileId,
      'offset'         => $offset,
      'limit'          => $limit,
      'is_read'        => $markAsRead == 'true' ? 1 : 0
    ];


    $messages = array_map(
      function (ProfileMessage $message){
        return $message->toJSON();
      },
      $this->profileIMService->getMessagesBy($criteria)
    );

    $result = [
      'source_profile' => $sourceProfileId,
      'messages'       => $messages,
      'total'          => count($messages),
    ];

    return $result;
  }
}