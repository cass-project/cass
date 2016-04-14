<?php
namespace EmailVerification\Service;

use Account\Entity\Account;
use Auth\Service\CurrentAccountService;
use EmailVerification\Repository\EmailVerificationRepository;

class EmailVerificationService
{
    /** @var CurrentAccountService */
    private $currentAccountService;

    /** @var EmailVerificationRepository */
    private $emailVerificationRepository;

    public function __construct(CurrentAccountService $currentAccountService, EmailVerificationRepository $emailVerificationRepository)
    {
        $this->currentAccountService = $currentAccountService;
        $this->emailVerificationRepository = $emailVerificationRepository;
    }

    public function requestForProfile(Account $forAccount, string $requestedEmail)
    {
        throw new \Exception('Not implemented');
    }

    public function confirm(string $token)
    {
        throw new \Exception('Not implemented');
    }
}