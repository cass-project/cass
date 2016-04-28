<?php
namespace Profile\Middleware\Command;

use Profile\Exception\NotOwnProfileException;
use Profile\Middleware\Request\ExpertInRequest;
use Psr\Http\Message\ServerRequestInterface;

class ExpertInDeleteCommand extends Command
{
    public function run(ServerRequestInterface $request) 
    {
        $profileId = (int) $request->getAttribute('profileId');
        
        if(! $this->validateIsOwnProfile($profileId)) {
            throw new NotOwnProfileException(sprintf('Profile with ID `%s` is not yours', $profileId));
        }
        
        $expertInParameters = explode(',',$request->getAttribute('theme_ids'));

        $this->profileService->deleteExpertsInParameters($profileId, $expertInParameters);
        return ['success'=> TRUE];
    }
}