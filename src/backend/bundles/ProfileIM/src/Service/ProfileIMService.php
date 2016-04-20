<?php
namespace ProfileIM\Service;

use Auth\Service\CurrentAccountService;
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


    public function getMessagesBy($criteria){
       return $this->profileMessageRepository->getMessageBy($criteria);
    }

    public function getMessageById($id){
        return $this->profileMessageRepository->getMessageById($id);
    }

    public function saveMessage(ProfileMessage $message):ProfileMessage
    {
        return $this->profileMessageRepository->saveMessage($message);
    }





}