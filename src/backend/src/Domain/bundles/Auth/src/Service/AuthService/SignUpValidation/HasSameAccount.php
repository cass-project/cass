<?php
namespace CASS\Domain\Bundles\Auth\Service\AuthService\SignUpValidation;

use CASS\Domain\Bundles\Account\Service\AccountService;
use CASS\Domain\Bundles\Auth\Parameters\SignUpParameters;
use CASS\Domain\Bundles\Auth\Exception\DuplicateAccountException;

class HasSameAccount implements Validator
{
    /** @var AccountService */
    private $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    public function validate(SignUpParameters $parameters) {
        $hasSameAccount = $this->accountService->hasAccountWithEmail($parameters->getEmail());

        $isValid = !$hasSameAccount;

        if(!$isValid) {
            throw new DuplicateAccountException(sprintf('%s already in use.', $parameters->getEmail()));
        }
    }

}