<?php
namespace Auth\Service\AuthService\SignUpValidation;

use Account\Service\AccountService;
use Auth\Service\AuthService\Exceptions\DuplicateAccountException;

class HasSameAccount implements Validator
{
    /** @var AccountService */
    private $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    public function validate(array $request) {
        $hasSameAccount = $this->accountService->hasAccountWithEmail($request['email']);

        $isValid = !$hasSameAccount;

        if(!$isValid) {
            throw new DuplicateAccountException(sprintf('%s already in use.', $request['email']));
        }
    }

}