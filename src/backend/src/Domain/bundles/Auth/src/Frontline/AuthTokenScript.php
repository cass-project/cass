<?php
namespace CASS\Domain\Bundles\Auth\Frontline;

use CASS\Application\Bundles\Frontline\FrontlineScript;
use CASS\Domain\Bundles\Auth\Service\CurrentAccountService;
use CASS\Domain\Bundles\Profile\Entity\Profile;
use CASS\Domain\Bundles\Profile\Formatter\ProfileExtendedFormatter;

class AuthTokenScript implements FrontlineScript
{
    /** @var CurrentAccountService */
    private $currentAccountService;

    /** @var ProfileExtendedFormatter */
    private $profileExtendedFormatter;

    public function __construct(
        CurrentAccountService $currentAccountService,
        ProfileExtendedFormatter $profileExtendedFormatter
    ) {
        $this->currentAccountService = $currentAccountService;
        $this->profileExtendedFormatter = $profileExtendedFormatter;
    }


    public function tags(): array {
        return [
            FrontlineScript::TAG_IS_AUTHENTICATED
        ];
    }

    public function __invoke(): array {
        $currentAccountService = $this->currentAccountService;

        if($currentAccountService->isAvailable()) {
            return [
                'auth' => [
                    'api_key' => $currentAccountService->getCurrentAccount()->getAPIKey(),
                    'account' => $currentAccountService->getCurrentAccount()->toJSON(),
                    'profiles' => array_map(function(Profile $profile) {
                        return $this->profileExtendedFormatter->formatOne($profile);
                    }, $currentAccountService->getCurrentAccount()->getProfiles()->toArray())
                ]
            ];
        }else{
            return [];
        }
    }
}