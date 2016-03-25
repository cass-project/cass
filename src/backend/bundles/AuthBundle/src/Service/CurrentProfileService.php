<?php
namespace Auth\Service;

use Data\Entity\Account;
use Data\Exception\Auth\AccountNotFoundException;
use Data\Repository\AccountRepository;
use Psr\Http\Message\ServerRequestInterface;

class CurrentProfileService
{
    const HEADER_API_KEY = 'X-Api-Key';

    /** @var AccountRepository */
    private $accountRepository;

    /** @var Account */
    private $account;

    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function getCurrentAccount(): Account {
        return $this->account;
    }

    public function setupAccountFromJSONBody(ServerRequestInterface $request) {
        $jsonBody = json_encode($request->getBody(), true);

        if(!isset($jsonBody['api_key'])) {
            throw new NotAuthenticatedException('API Key is not available');
        }

        try {
            $this->account = $this->accountRepository->findByAPIKey($jsonBody['api_key']);
        }catch(AccountNotFoundException $e) {
            throw new NotAuthenticatedException('Invalid API Key');
        }
    }

    public function setupAccountFromHeader(ServerRequestInterface $request)
    {
        if(!$request->hasHeader(self::HEADER_API_KEY)) {
            throw new NotAuthenticatedException('API Key is not available');
        }

        try {
            $this->account = $this->accountRepository->findByAPIKey($request->getHeader(self::HEADER_API_KEY)[0]);
        }catch(AccountNotFoundException $e) {
            throw new NotAuthenticatedException('Invalid API Key');
        }
    }
}