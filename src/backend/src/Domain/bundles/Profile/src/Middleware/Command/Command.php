<?php
namespace CASS\Domain\Profile\Middleware\Command;

use CASS\Domain\Account\Service\AccountService;
use CASS\Domain\Auth\Service\CurrentAccountService;
use CASS\Domain\Profile\Entity\Profile\Greetings;
use CASS\Domain\Profile\Formatter\ProfileExtendedFormatter;
use CASS\Domain\Profile\Service\ProfileService;
use CASS\Domain\Profile\Validation\ProfileValidationService;

abstract class Command implements \CASS\Application\Command\Command
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