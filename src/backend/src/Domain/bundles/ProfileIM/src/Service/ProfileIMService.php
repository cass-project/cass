<?php
namespace Domain\ProfileIM\Service;

use Domain\Auth\Service\CurrentAccountService;
use Application\Util\Seek;
use Domain\ProfileIM\Entity\ProfileMessage;
use Domain\ProfileIM\Repository\ProfileMessageRepository;

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

    public function getMessageById($id): ProfileMessage
    {
        return $this->profileMessageRepository->getMessageById($id);
    }

    public function createMessage(ProfileMessage $message): ProfileMessage
    {
        return $this->profileMessageRepository->createMessage($message);
    }

    public function getMessages(int $sourceProfileId, int $targetProfileId, Seek $seek): array
    {
        /** @var ProfileMessage[] $result */
        $result = $this->profileMessageRepository->getMessages($sourceProfileId, $targetProfileId, $seek);;

        return $result;
    }

    public function markMessagesAsRead(array $messages)
    {
        array_walk($messages, function(ProfileMessage $message) {
            $message->setAsRead();
        });

        return $this->profileMessageRepository->updateMessages($messages);
    }

    public function getUnreadMessagesByProfileId(int $profileId): array
    {
        return $this->profileMessageRepository->getUnreadMessagesByProfile($profileId);
    }
}