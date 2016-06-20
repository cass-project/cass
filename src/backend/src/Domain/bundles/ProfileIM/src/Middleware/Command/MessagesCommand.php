<?php
namespace Domain\ProfileIM\Middleware\Command;

use Application\REST\Response\ResponseBuilder;
use Application\Util\Seek;
use Domain\ProfileIM\Entity\ProfileMessage;
use Domain\ProfileIM\Exception\SameTargetAndSourceException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class MessagesCommand extends Command
{
    const MAX_MESSAGE_LIMIT = 500;

    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): ResponseInterface
    {
        $qp = $request->getQueryParams();

        $sourceProfileId = $request->getAttribute('sourceProfileId');
        $targetProfileId = $this->currentAccountService->getCurrentProfile()->getId();
        $offset = $request->getAttribute('offset');
        $limit = $request->getAttribute('limit');
        $markAsRead = (bool)($qp['markAsRead'] ?? null);

        if($sourceProfileId == $targetProfileId) {
            throw new SameTargetAndSourceException("Source profile must not be same as target profile");
        }

        $seek = new Seek(self::MAX_MESSAGE_LIMIT, $offset, $limit);
        $messages = $this->profileIMService->getMessages($sourceProfileId, $targetProfileId, $seek);

        if($markAsRead) {
            $this->profileIMService->markMessagesAsRead($messages);
        }

        return $responseBuilder
            ->setStatusSuccess()
            ->setJson([
                'source_profile' => $this->profileService->getProfileById($sourceProfileId)->toJSON(),
                'messages' => array_map(function(ProfileMessage $message) {
                    return $message->toJSON();
                }, $messages),
                'total' => count($messages),
            ])
            ->build();
    }
}