<?php
namespace CASS\Domain\Auth\Formatter;

use CASS\Domain\Account\Entity\Account;
use CASS\Domain\Profile\Entity\Profile;
use CASS\Domain\Profile\Entity\Profile\Greetings;
use CASS\Domain\Profile\Formatter\ProfileExtendedFormatter;

class SignInFormatter
{
    /** @var ProfileExtendedFormatter */
    private $profileFormatter;
    
    public function __construct(ProfileExtendedFormatter $profileFormatter)
    {
        $this->profileFormatter = $profileFormatter;
    }

    public function format(Account $account, array $frontline)
    {
        $profiles = array_map(function(Profile $profile) {
            return $this->profileFormatter->format($profile);
        }, $account->getProfiles()->toArray());

        return [
            "api_key" => $account->getAPIKey(),
            "account" => $account->toJSON(),
            "profiles" => $profiles,
            "frontline" => $frontline
        ];
    }
}