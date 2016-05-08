<?php
namespace Domain\Profile\Middleware\Command;

use Domain\Profile\Exception\NotOwnProfileException;
use Domain\Profile\Middleware\Request\ExpertInRequest;
use Psr\Http\Message\ServerRequestInterface;

class ExpertInPostCommand extends Command
{
    public function run(ServerRequestInterface $request)
    {
        $profileId = (int) $request->getAttribute('profileId');

        if(! $this->validateIsOwnProfile($profileId)) {
            throw new NotOwnProfileException(sprintf('Domain\Profile with ID `%s` is not yours', $profileId));
        }

        $expertInRequest = new ExpertInRequest($request);
        $expertInParameters = $expertInRequest->getParameters();

        $this->profileService->mergeExpertsInParameters($profileId, $expertInParameters);
        return ['success'=> TRUE];
    }
}