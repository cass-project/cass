<?php
namespace Domain\Auth\Formatter;

use Domain\Account\Entity\Account;
use Domain\Profile\Entity\Profile;
use Domain\Profile\Entity\Profile\Greetings;

class SignInFormatter
{
    public function format(Account $account, array $frontline)
    {
        $profiles = array_map(function(Profile $profile) {
            return $profile->toJSON();
        }, $account->getProfiles()->toArray());

        return [
            "api_key" => $account->getAPIKey(),
            "account" => $account->toJSON(),
            "profiles" => $profiles,
            "frontline" => $frontline
        ];
    }
}