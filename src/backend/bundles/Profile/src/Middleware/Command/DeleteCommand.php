<?php
namespace Profile\Middleware\Command;

use Common\Exception\BadCommandCallException;
use Profile\Exception\LastProfileException;
use Psr\Http\Message\ServerRequestInterface;

class DeleteCommand extends Command
{
    public function run(ServerRequestInterface $request)
    {
        try {
            $profileId = $this->validateProfileId($request->getAttribute('profileId'));
            $currentAccountId = $this->currentAccountService->getCurrentAccount()->getId();

            $this->profileService->deleteProfile($profileId, $currentAccountId);

            return true;
        }catch(LastProfileException $e){
            throw new BadCommandCallException($e->getMessage());
        }
    }
}