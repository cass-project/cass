<?php
namespace ProfileIM\Service;

use Auth\Service\CurrentAccountService;
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
}