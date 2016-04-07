<?php
namespace Auth\Service\AuthService\SignUpValidation;

use Auth\Service\AuthService\Exceptions\DuplicateAccountException;
use Data\Repository\AccountRepository;

class HasSameAccount implements Validator
{
    /** @var AccountRepository */
    private $accountRepository;

    public function __construct(AccountRepository $accountRepository) {
        $this->accountRepository = $accountRepository;
    }

    public function validate(array $request) {
        $hasSameAccount = $this->accountRepository->hasAccountWithEmail($request['email']);

        $isValid = !$hasSameAccount;

        if(!$isValid) {
            throw new DuplicateAccountException(sprintf('%s already in use.', $request['email']));
        }
    }

}