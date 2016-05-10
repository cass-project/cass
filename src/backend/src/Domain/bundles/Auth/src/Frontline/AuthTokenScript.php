<?php
namespace Domain\Auth\Frontline;

use Application\Frontline\FrontlineScript;
use Domain\Auth\Service\CurrentAccountService;
use Domain\Profile\Entity\Profile;

class AuthTokenScript implements FrontlineScript
{
    /** @var CurrentAccountService */
    private $currentAccountService;

    public function __construct(CurrentAccountService $currentAccountService) {
        $this->currentAccountService = $currentAccountService;
    }

    public function __invoke(): array {
        $currentAccountService = $this->currentAccountService;

        if($currentAccountService->isAvailable()) {
            return [
                'auth' => [
                    'api_key' => $currentAccountService->getCurrentAccount()->getAPIKey(),
                    'account' => $currentAccountService->getCurrentAccount()->toJSON(),
                    'profiles' => array_map(function(Profile $profile) {
                        return $profile->toJSON();
                    }, $currentAccountService->getCurrentAccount()->getProfiles()->toArray())
                ]
            ];
        }else{
            return [];
        }
    }
}