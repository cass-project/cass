<?php
namespace Auth\Service\AuthService\Validations\SignUp;

use Auth\Service\AuthService\Exceptions\DuplicateAccountException;
use Data\Repository\AccountRepository;

class IsNewAccount extends Validator
{

    /** @var AccountRepository */
    private $accountRepository;

    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function validate()
    {
        $email = $this->credentials['email'] ?? null;
        $phone = $this->credentials['phone'] ?? null;

        if ($this->accountRepository->isAccountExist($email, $phone)) {
            throw new DuplicateAccountException(sprintf('%s already in use.', $phone??$email));
        }
    }
}