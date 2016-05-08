<?php
namespace Application\Profile\Middleware\Command;

use Application\Common\Exception\BadCommandCallException;
use Application\Profile\Exception\MaxProfilesReachedException;
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