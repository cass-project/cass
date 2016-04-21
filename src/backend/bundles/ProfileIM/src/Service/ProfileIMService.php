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

    public function getMessageById($id){
        return $this->profileMessageRepository->getMessageById($id);
    }

    public function saveMessage(ProfileMessage $message):ProfileMessage
    {
        return $this->profileMessageRepository->saveMessage($message);
    }


    /** @return ProfileMessage[] */
    public function getMessagesBySourceProfile(int $sourceProfileId, Seek $seek): array
    {
        return $this->profileMessageRepository->getMessagesBySourceProfile($sourceProfileId, $seek);
    }

    public function markMessagesAsRead(array $messages)
    {
        return true;
    }
}