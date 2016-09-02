<?php
namespace CASS\Domain\Auth\Service;

use CASS\Domain\Account\Entity\Account;

class PasswordVerifyService
{
    public function generatePassword(string $source): string 
    {
        return password_hash($source, PASSWORD_DEFAULT);
    }
    
    public function verifyPassword(Account $account, string $password): bool
    {
        return password_verify($password, $account->getPassword());
    }
}