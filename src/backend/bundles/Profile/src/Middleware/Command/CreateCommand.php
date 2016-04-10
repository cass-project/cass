<?php
namespace Profile\Middleware\Command;

use Common\Exception\BadCommandCallException;
use Profile\Exception\MaxProfilesReachedException;
use Psr\Http\Message\ServerRequestInterface;

class CreateCommand extends Command
{
    public function run(ServerRequestInterface $request)
    {
        $accountId = $request->getAttribute('accountId');

        if($accountId === 'current') {
            $account = $this->currentAccountService->getCurrentAccount();
        }else{
            throw new \Exception('Not implemented');
        }

        try {
            $profile = $this->profileService->createProfileForAccount($account);

            return [
                'entity' => $profile->toJSON()
            ];
        }catch(MaxProfilesReachedException $e){
            throw new BadCommandCallException($e->getMessage());
        }
    }
}