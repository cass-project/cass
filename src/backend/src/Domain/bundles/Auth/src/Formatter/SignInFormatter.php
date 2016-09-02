<?php
namespace CASS\Domain\Bundles\Auth\Formatter;

use CASS\Domain\Bundles\Account\Entity\Account;
use CASS\Domain\Bundles\Profile\Entity\Profile;
use CASS\Domain\Bundles\Profile\Entity\Profile\Greetings;
use CASS\Domain\Bundles\Profile\Formatter\ProfileExtendedFormatter;

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