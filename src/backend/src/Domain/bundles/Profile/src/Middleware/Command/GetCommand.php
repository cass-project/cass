<?php
namespace Domain\Profile\Middleware\Command;


use Psr\Http\Message\ServerRequestInterface;

class GetCommand extends Command
{
    public function run(ServerRequestInterface $request)
    {
        $profileId = $this->validateProfileId($request->getAttribute('profileId'));
        $profile = $this->profileService->getProfileById($profileId);

        return [
            'entity' => $profile->toJSON()
        ];
    }
}