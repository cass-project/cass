<?php
namespace ProfileIM\Service;

use Auth\Service\CurrentAccountService;
use Common\Util\Seek;
use ProfileIM\Entity\ProfileMessage;
use ProfileIM\Repository\ProfileMessageRepository;

class ProfileIMService
{
    /** @var CurrentAccountService */
    private $currentAccountService;

    /** @var ProfileMessageRepository */
    private $profileMessageRepository;

    public function __construct(CurrentAccountService $currentAccountService, ProfileMessageRepository $profileMessageRepository)
    {
        $this->currentAccountService = $currentAccountService;
        $this->profileMessageRepository = $profileMessageRepository;
    }

    public function getMessageById($id): ProfileMessage {
        return $this->profileMessageRepository->getMessageById($id);
    }

    public function createMessage(ProfileMessage $message): ProfileMessage
    {
        return $this->profileMessageRepository->createMessage($message);
    }

    /** @return ProfileMessage[] */
    public function getMessages(int $sourceProfileId, int $targetProfileId, Seek $seek): array
    {
        return $this->profileMessageRepository->getMessages($sourceProfileId, $targetProfileId, $seek);
    }

    public function markMessagesAsRead(array $messages)
    {
        array_walk($messages, function(ProfileMessage $message){
            $message->setAsRead();
        });

        return $this->profileMessageRepository->updateMessages($messages);
    }

    public function getUnreadMessagesByProfileId(int $profileId): array
    {
        return $this->profileMessageRepository->getUnreadMessagesByProfile($profileId);
    }
}