<?php
namespace Domain\Profile\Middleware\Command;

use Psr\Http\Message\ServerRequestInterface;

class SwitchCommand extends Command
{
    public function run(ServerRequestInterface $request)
    {
        $profileId = $this->validateProfileId($request->getAttribute('profileId'));
        $profile = $this->profileService->switchTo($this->currentAccountService->getCurrentAccount(), $profileId);

        return [
            'entity' => $profile->toJSON()
        ];
    }
}