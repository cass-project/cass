<?php
namespace Profile\Middleware\Command;

use Profile\Exception\NotOwnProfileException;
use Profile\Middleware\Request\ExpertInRequest;
use Psr\Http\Message\ServerRequestInterface;

class ExpertInPostCommand extends Command
{
    public function run(ServerRequestInterface $request)
    {
        $profileId = (int) $request->getAttribute('profileId');

        if(! $this->validateIsOwnProfile($profileId)) {
            throw new NotOwnProfileException(sprintf('Profile with ID `%s` is not yours', $profileId));
        }

        $expertInRequest = new ExpertInRequest($request);
        $expertInParameters = $expertInRequest->getParameters();

        $this->profileService->mergeExpertsInParameters($profileId, $expertInParameters);
        return ['success'=> TRUE];
    }
}