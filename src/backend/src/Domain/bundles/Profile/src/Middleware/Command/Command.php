<?php
namespace Domain\Profile\Middleware\Command;

use Domain\Account\Service\AccountService;
use Domain\Auth\Service\CurrentAccountService;
use Domain\Profile\Entity\Profile\Greetings;
use Domain\Profile\Formatter\ProfileExtendedFormatter;
use Domain\Profile\Service\ProfileService;
use Domain\Profile\Validation\ProfileValidationService;

abstract class Command implements \Application\Command\Command
{
    /** @var CurrentAccountService */
    protected $currentAccountService;

    /** @var AccountService */
    protected $accountService;

    /** @var ProfileService */
    protected $profileService;

    /** @var ProfileExtendedFormatter */
    protected $profileExtendedFormatter;

    /** @var ProfileValidationService */
    protected $validation;

    public function __construct(
        CurrentAccountService $currentAccountService,
        AccountService $accountService,
        ProfileService $profileService,
        ProfileExtendedFormatter $profileExtendedFormatter,
        ProfileValidationService $validationService
    ) {
        $this->currentAccountService = $currentAccountService;
        $this->accountService = $accountService;
        $this->profileService = $profileService;
        $this->profileExtendedFormatter = $profileExtendedFormatter;
        $this->validation = $validationService;
    }
}