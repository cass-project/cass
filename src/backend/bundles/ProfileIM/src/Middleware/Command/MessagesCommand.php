<?php
namespace ProfileIM\Middleware\Command;

use Common\Util\Seek;
use ProfileIM\Entity\ProfileMessage;
use ProfileIM\Exception\SameTargetAndSourceException;
use Psr\Http\Message\ServerRequestInterface;

class MessagesCommand extends Command
{
  const MAX_MESSAGE_LIMIT = 500;

  public function run(ServerRequestInterface $request){
    $qp = $request->getQueryParams();

    $sourceProfileId = $request->getAttribute('sourceProfileId');
    $targetProfileId = $this->currentAccountService->getCurrentProfile()->getId();
    $offset          = $request->getAttribute('offset');
    $limit           = $request->getAttribute('limit');
    $markAsRead      = (bool) ($qp['markAsRead'] ?? null);

    if($sourceProfileId == $targetProfileId) {
      throw new SameTargetAndSourceException("souurce profile must not be same as target profile");
    }

    $seek = new Seek(self::MAX_MESSAGE_LIMIT, $offset, $limit);
    $messages = $this->profileIMService->getMessages($sourceProfileId, $targetProfileId, $seek);

    if($markAsRead) {
      $this->profileIMService->markMessagesAsRead($messages);
    }

    return [
        'source_profile' => $this->profileService->getProfileById($sourceProfileId)->toJSON(),
        'messages' => array_map(function (ProfileMessage $message) {
          return $message->toJSON();
        }, $messages),
        'total' => count($messages),
    ];
  }
}