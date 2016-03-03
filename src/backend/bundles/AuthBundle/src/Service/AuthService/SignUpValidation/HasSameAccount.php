<?php
namespace Auth\Service\AuthService\SignUpValidation;

use Auth\Service\AuthService\Exceptions\DuplicateAccountException;
use Data\Repository\AccountRepository;
use Psr\Http\Message\ServerRequestInterface;

class HasSameAccount implements Validator
{
    /** @var AccountRepository */
    private $accountRepository;

    public function __construct(AccountRepository $accountRepository) {
        $this->accountRepository = $accountRepository;
    }

    public function validate(ServerRequestInterface $request) {
        $hasSameAccount = $this->accountRepository->isAccountExist($request['email'] ?? $request['phone']);

        $isValid = !$hasSameAccount;

        if(!$isValid) {
            throw new DuplicateAccountException(sprintf('%s already in use.', $request['email'] ?? $request['phone']));
        }
    }

}